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
                }
            }
        }

        return response('OK', 200);
    }
}
