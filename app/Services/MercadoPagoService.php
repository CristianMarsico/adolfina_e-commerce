<?php

namespace App\Services;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\Resources\Preference;

class MercadoPagoService
{
    private PreferenceClient $preferenceClient;

    public function __construct()
    {
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
        $this->preferenceClient = new PreferenceClient();
    }

    public function crearPreferencia(array $items, array $payer, string $externalReference, array $backUrls): Preference
    {
        $request = $this->buildPreferenceRequest($items, $payer, $externalReference, $backUrls);

        try {
            return $this->preferenceClient->create($request);
        } catch (MPApiException $e) {
            throw new \RuntimeException('Error al crear preferencia MP: ' . $e->getMessage());
        }
    }

    private function buildPreferenceRequest(array $items, array $payer, string $externalReference, array $backUrls): array
    {
        $mpItems = [];
        foreach ($items as $item) {
            $mpItems[] = [
                'id' => (string) $item['producto_id'],
                'title' => $item['nombre'],
                'description' => $item['descripcion'] ?? '',
                'quantity' => (int) $item['cantidad'],
                'unit_price' => (float) $item['precio'],
                'currency_id' => 'ARS',
            ];
        }

        return [
            'items' => $mpItems,
            'payer' => [
                'name' => $payer['name'] ?? '',
                'email' => $payer['email'] ?? '',
            ],
            'external_reference' => $externalReference,
            'back_urls' => [
                'success' => $backUrls['success'],
                'failure' => $backUrls['failure'],
                'pending' => $backUrls['pending'],
            ],
            'auto_return' => 'approved',
            'notification_url' => $backUrls['notification'] ?? null,
            'statement_descriptor' => 'PANALERA',
        ];
    }

    public function obtenerPago(string $paymentId): ?\MercadoPago\Resources\Payment
    {
        try {
            $client = new \MercadoPago\Client\Payment\PaymentClient();
            return $client->get((int) $paymentId);
        } catch (\Exception $e) {
            return null;
        }
    }
}
