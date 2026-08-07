<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function mp(Request $request, MercadoPagoService $mp)
    {
        Log::info('Webhook MP recibido', $request->all());

        $secret = config('services.mercadopago.webhook_secret');

        if ($secret) {
            $signature = $request->header('X-Signature');
            if (!$signature || !$this->verifySignature($signature, $secret, $request)) {
                Log::warning('Webhook MP: firma inválida');
                return response('Forbidden', 403);
            }
        }

        $paymentId = $request->input('data.id') ?? $request->query('data_id') ?? $request->input('id');
        $topic = $request->input('type') ?? $request->input('topic');

        if (!$paymentId) {
            return response('OK', 200);
        }

        if ($topic === 'merchant_order') {
            $this->procesarMerchantOrder($mp, (string) $paymentId);
        } elseif ($topic === 'payment') {
            $this->procesarPago($mp, (string) $paymentId);
        } elseif ($topic === 'order') {
            $this->procesarOrden($mp, (string) $paymentId);
        }

        return response('OK', 200);
    }

    private function procesarMerchantOrder(MercadoPagoService $mp, string $merchantOrderId): void
    {
        $order = $mp->obtenerMerchantOrder($merchantOrderId);

        if (!$order || !$order->external_reference) {
            return;
        }

        $pedido = Pedido::find($order->external_reference);

        if (!$pedido) {
            return;
        }

        $payments = $order->payments ?? [];

        $approved = false;
        $approvedId = null;
        $terminal = count($payments) > 0;

        foreach ($payments as $payment) {
            $status = $payment->status ?? null;

            if ($status === 'approved') {
                $approved = true;
                $approvedId = $payment->id;
            }

            if ($status !== 'rejected' && $status !== 'cancelled' && $status !== 'refunded' && $status !== 'charged_back') {
                $terminal = false;
            }
        }

        if ($approved) {
            $this->marcarPagado($pedido, (string) $approvedId, (string) $merchantOrderId);
        } elseif ($terminal) {
            $pedido->update([
                'mp_status' => 'rejected',
                'estado' => 'fallado',
            ]);
        }
    }

    private function procesarOrden(MercadoPagoService $mp, string $orderId): void
    {
        $order = $mp->obtenerOrdenQR($orderId);

        if (!$order || empty($order['external_reference'])) {
            return;
        }

        $pedido = Pedido::find($order['external_reference']);

        if (!$pedido) {
            return;
        }

        $approved = false;
        $approvedId = null;

        if (($order['status'] ?? null) === 'processed' && ($order['status_detail'] ?? null) === 'accredited') {
            $approved = true;
        }

        $payments = $order['transactions']['payments'] ?? $order['payments'] ?? [];

        $terminal = count($payments) > 0;

        foreach ($payments as $payment) {
            $status = $payment['status'] ?? null;
            $detail = $payment['status_detail'] ?? null;

            if ($status === 'approved' || ($status === 'processed' && $detail === 'accredited')) {
                $approved = true;
                $approvedId = $payment['reference_id'] ?? $payment['id'] ?? $approvedId;
            }

            if ($status !== 'rejected' && $status !== 'cancelled' && $status !== 'refunded' && $status !== 'charged_back') {
                $terminal = false;
            }
        }

        if ($approved) {
            $this->marcarPagado($pedido, (string) ($approvedId ?? $order['id']), $orderId);
        } elseif ($terminal) {
            $pedido->update([
                'mp_status' => 'rejected',
                'estado' => 'fallado',
            ]);
        }
    }

    private function procesarPago(MercadoPagoService $mp, string $paymentId): void
    {
        $payment = $mp->obtenerPago($paymentId);

        if (!$payment || !$payment->external_reference) {
            return;
        }

        $pedido = Pedido::find($payment->external_reference);

        if (!$pedido) {
            return;
        }

        $mpStatus = $payment->status;

        $pedido->update([
            'mp_payment_id' => $paymentId,
            'mp_status' => $mpStatus,
            'mp_merchant_order_id' => $payment->merchant_order_id,
            'estado' => match ($mpStatus) {
                'approved' => 'pagado',
                'pending', 'in_process', 'in_mediation' => 'pendiente',
                'rejected', 'cancelled', 'refunded', 'charged_back' => 'fallado',
                default => 'pendiente',
            },
        ]);

        if ($mpStatus === 'approved') {
            $this->descontarStock($pedido);
        }
    }

    private function marcarPagado(Pedido $pedido, string $paymentId, ?string $merchantOrderId): void
    {
        $estadoAnterior = $pedido->estado;

        $pedido->update([
            'mp_payment_id' => $paymentId,
            'mp_status' => 'approved',
            'mp_merchant_order_id' => $merchantOrderId,
            'estado' => 'pagado',
        ]);

        if ($estadoAnterior !== 'pagado') {
            $this->descontarStock($pedido);
        }
    }

    private function descontarStock(Pedido $pedido): void
    {
        foreach ($pedido->items as $item) {
            $producto = \App\Models\Producto::find($item->producto_id);
            if ($producto && $producto->stock !== null) {
                $producto->decrement('stock', $item->cantidad);
            }
        }
    }

    private function verifySignature(string $header, string $secret, Request $request): bool
    {
        $parts = [];
        foreach (explode(',', $header) as $pair) {
            $kv = explode('=', $pair, 2);
            if (count($kv) === 2) {
                $parts[trim($kv[0])] = trim($kv[1]);
            }
        }

        $ts = $parts['ts'] ?? null;
        $v1 = $parts['v1'] ?? null;

        if (!$ts || !$v1) {
            return false;
        }

        if (abs((int) round(microtime(true) * 1000) - (int) $ts) > 300000) {
            return false;
        }

        $dataId = (string) $request->query('data_id', '');
        $requestId = (string) $request->header('x-request-id', '');

        $manifestParts = [];
        if ($dataId !== '') {
            $manifestParts[] = 'id:' . strtolower($dataId);
        }
        if ($requestId !== '') {
            $manifestParts[] = 'request-id:' . $requestId;
        }
        $manifestParts[] = 'ts:' . $ts;
        $manifest = implode(';', $manifestParts) . ';';

        $expected = hash_hmac('sha256', $manifest, $secret);

        return hash_equals($expected, $v1);
    }
}
