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

        $paymentId = $request->input('data.id') ?? $request->input('id');
        $topic = $request->input('type') ?? $request->input('topic');

        if (!$paymentId) {
            return response('OK', 200);
        }

        if ($topic === 'payment' || $topic === 'merchant_order') {
            $payment = $mp->obtenerPago($paymentId);

            if (!$payment) {
                return response('OK', 200);
            }

            $externalRef = $payment->external_reference ?? null;

            if ($externalRef) {
                $pedido = Pedido::find($externalRef);

                if ($pedido) {
                    $mpStatus = $payment->status;
                    $estadoAnterior = $pedido->estado;

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

                    if ($mpStatus === 'approved' && $estadoAnterior !== 'pagado') {
                        foreach ($pedido->items as $item) {
                            $producto = \App\Models\Producto::find($item->producto_id);
                            if ($producto) {
                                if ($item->atributo_id) {
                                    $atributo = $producto->atributos()->find($item->atributo_id);
                                    if ($atributo && $atributo->stock !== null) {
                                        $atributo->decrement('stock', $item->cantidad);
                                    }
                                } elseif ($producto->stock !== null) {
                                    $producto->decrement('stock', $item->cantidad);
                                }
                            }
                        }
                    }
                }
            }
        }

        return response('OK', 200);
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

        if (abs(time() - (int) $ts) > 300) {
            return false;
        }

        $body = $request->getContent();
        $dataId = $request->input('data.id') ?? $request->input('id') ?? '';
        $payload = "{$dataId}|{$ts}|{$body}";
        $expected = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, $v1);
    }
}
