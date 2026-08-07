<?php

namespace App\Services;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\MerchantOrder\MerchantOrderClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\Resources\Preference;
use Illuminate\Support\Facades\Http;

class MercadoPagoService
{
    private PreferenceClient $preferenceClient;
    private bool $testMode;
    private string $accessToken;

    public function __construct()
    {
        $this->testMode = config('services.mercadopago.sandbox', false);
        $this->accessToken = config('services.mercadopago.access_token') ?? '';

        MercadoPagoConfig::setAccessToken($this->accessToken);
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
                'init_point' => '#',
                'sandbox_init_point' => '#',
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

    public function crearPedidoQR(array $items, float $total, string $externalReference): array
    {
        $externalPosId = config('services.mercadopago.external_pos_id');
        if (!$externalPosId) {
            throw new \RuntimeException('Falta configurar MERCADO_PAGO_EXTERNAL_POS_ID.');
        }

        $mpItems = [];
        foreach ($items as $item) {
            $mpItems[] = [
                'title' => $item['nombre'] ?? 'Producto',
                'quantity' => (int) ($item['cantidad'] ?? 1),
                'unit_price' => number_format((float) ($item['precio'] ?? 0), 2, '.', ''),
                'unit_measure' => 'unit',
            ];
        }

        $request = [
            'type' => 'qr',
            'total_amount' => number_format((float) $total, 2, '.', ''),
            'external_reference' => $externalReference,
            'description' => 'Pedido #' . $externalReference . ' - Adolfina',
            'expiration_time' => 'PT15M',
            'config' => [
                'qr' => [
                    'external_pos_id' => $externalPosId,
                    'mode' => 'dynamic',
                ],
            ],
            'transactions' => [
                'payments' => [
                    ['amount' => number_format((float) $total, 2, '.', '')],
                ],
            ],
            'items' => $mpItems,
        ];

        $response = Http::withToken($this->accessToken)
            ->withHeaders(['X-Idempotency-Key' => (string) $externalReference . '_' . time()])
            ->post('https://api.mercadopago.com/v1/orders', $request);

        if (!$response->successful()) {
            $detalle = $response->json('message') ?? $response->body();
            throw new \RuntimeException("Error MP al crear QR (HTTP {$response->status()}): $detalle");
        }

        return [
            'id' => $response->json('id'),
            'qr_data' => $response->json('type_response.qr_data'),
        ];
    }

    public function crearTiendaYcaja(string $nombreTienda, array $location = null, string $externalPosId = null): array
    {
        $user = Http::withToken($this->accessToken)
            ->get('https://api.mercadopago.com/users/me');

        if (!$user->successful()) {
            throw new \RuntimeException("Error MP al obtener usuario (HTTP {$user->status()}): {$user->body()}");
        }

        $userId = $user->json('id');

        $location = $location ?? [
            'latitude' => -34.6037,
            'longitude' => -58.3816,
            'street_name' => 'Calle Principal',
            'street_number' => '1000',
            'city_name' => 'Palermo',
            'state_name' => 'Capital Federal',
            'zip_code' => '1425',
        ];

        $storeResponse = Http::withToken($this->accessToken)
            ->post("https://api.mercadopago.com/users/{$userId}/stores", [
                'name' => $nombreTienda,
                'location' => $location,
            ]);

        if (!$storeResponse->successful()) {
            throw new \RuntimeException("Error MP al crear tienda (HTTP {$storeResponse->status()}): {$storeResponse->body()}");
        }

        $storeId = $storeResponse->json('id');

        $posResponse = Http::withToken($this->accessToken)
            ->post('https://api.mercadopago.com/pos', [
                'name' => 'Caja Principal',
                'fixed_amount' => true,
                'store_id' => $storeId,
                'category' => 621102,
                'external_id' => $externalPosId ?? 'ADOLFINA001',
            ]);

        if (!$posResponse->successful()) {
            throw new \RuntimeException("Error MP al crear caja (HTTP {$posResponse->status()}): {$posResponse->body()}");
        }

        return [
            'store_id' => $storeId,
            'external_pos_id' => $posResponse->json('external_id') ?? $posResponse->json('id'),
        ];
    }

    public function obtenerMerchantOrder(string $merchantOrderId): ?\MercadoPago\Resources\MerchantOrder
    {
        if ($this->testMode) {
            return null;
        }

        try {
            $client = new MerchantOrderClient();
            return $client->get((int) $merchantOrderId);
        } catch (\Exception $e) {
            return null;
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

    public function obtenerOrdenQR(string $orderId): ?array
    {
        try {
            $response = Http::withToken($this->accessToken)
                ->get("https://api.mercadopago.com/v1/orders/{$orderId}");

            if (!$response->successful()) {
                return null;
            }

            return $response->json();
        } catch (\Exception $e) {
            return null;
        }
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
