<?php

namespace App\Services;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\Resources\Preference;

class MercadoPagoService
{
    private PreferenceClient $preferenceClient;
    private bool $testMode;

    public function __construct()
    {
        $this->testMode = config('services.mercadopago.sandbox', false);

        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
        $this->preferenceClient = new PreferenceClient();
    }

    public function isTestMode(): bool
    {
        return $this->testMode;
    }

    public function crearPreferencia(array $items, array $payer, string $externalReference, array $backUrls, ?string $token = null): Preference|array
    {
        if ($this->testMode) {
            return [
                'id' => 'TEST_' . $externalReference . '_' . time(),
                'init_point' => route('checkout.test-pagar', ['pedido' => $externalReference, 'token' => $token]),
                'sandbox_init_point' => route('checkout.test-pagar', ['pedido' => $externalReference, 'token' => $token]),
            ];
        }

        $request = $this->buildPreferenceRequest($items, $payer, $externalReference, $backUrls);

        try {
            return $this->preferenceClient->create($request);
        } catch (MPApiException $e) {
            $body = $e->getApiResponse()->getContent();
            $status = $e->getStatusCode();
            $detalle = $body['message'] ?? json_encode($body);
            throw new \RuntimeException("Error MP (HTTP $status): $detalle");
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

        $request = [
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
            'statement_descriptor' => 'PANALERA',
        ];

        $notificationUrl = $backUrls['notification'] ?? null;
        if ($notificationUrl && !str_contains($notificationUrl, 'localhost') && !str_contains($notificationUrl, '127.0.0.1')) {
            $request['notification_url'] = $notificationUrl;
        }

        return $request;
    }

    public function obtenerPago(string $paymentId): ?\MercadoPago\Resources\Payment
    {
        if ($this->testMode) {
            return null;
        }

        try {
            $client = new \MercadoPago\Client\Payment\PaymentClient();
            return $client->get((int) $paymentId);
        } catch (\Exception $e) {
            return null;
        }
    }
}
