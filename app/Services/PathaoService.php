<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Courierapi;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PathaoService
{
    protected ?Courierapi $courier = null;
    protected string $baseUrl;
    protected ?string $token = null;

    public function __construct()
    {
        $this->reloadConfig();
    }

    public function reloadConfig(): void
    {
        $this->courier = Courierapi::where('type', 'pathao')->first();

        $rawUrl = $this->courier && !empty($this->courier->url)
            ? trim($this->courier->url)
            : 'https://api-hermes.pathao.com';

        // Normalize base URL so endpoints always prepend /aladdin
        $rawUrl = rtrim($rawUrl, '/');
        if (str_ends_with($rawUrl, '/aladdin')) {
            $rawUrl = substr($rawUrl, 0, -8);
        }
        $this->baseUrl = $rawUrl . '/aladdin';

        $this->token = $this->courier ? trim($this->courier->token ?? '') : null;
    }

    public function isConfigured(): bool
    {
        if (empty($this->courier) || (int) $this->courier->status !== 1) {
            return false;
        }

        // Active if we have a token OR credentials to generate one
        return !empty($this->token) || (
            !empty($this->courier->api_key) &&
            !empty($this->courier->secret_key) &&
            !empty($this->courier->username) &&
            !empty($this->courier->password)
        );
    }

    public function getCourier(): ?Courierapi
    {
        return $this->courier;
    }

    public function getTokenStatus(): array
    {
        if (empty($this->token)) {
            $hasCredentials = !empty($this->courier->api_key) &&
                !empty($this->courier->secret_key) &&
                !empty($this->courier->username) &&
                !empty($this->courier->password);

            return [
                'status' => 'missing',
                'is_expired' => true,
                'message' => $hasCredentials
                    ? 'Pathao token is not generated yet. Click "Generate Token" to connect.'
                    : 'Pathao credentials and access token are missing.',
                'exp_date' => null,
            ];
        }

        // 1. Check stored token_expires_at if present
        if (!empty($this->courier->token_expires_at)) {
            $expCarbon = Carbon::parse($this->courier->token_expires_at);
            $isExpired = $expCarbon->isPast();
            return [
                'status' => $isExpired ? 'expired' : 'valid',
                'is_expired' => $isExpired,
                'exp_timestamp' => $expCarbon->timestamp,
                'exp_date' => $expCarbon->format('Y-m-d H:i:s'),
                'merchant_id' => null,
                'message' => $isExpired
                    ? "Token expired on {$expCarbon->format('Y-m-d H:i:s')}. Please generate a new token."
                    : "Token is active (expires on {$expCarbon->format('Y-m-d H:i:s')}).",
            ];
        }

        // 2. Fallback to JWT payload parsing
        $parts = explode('.', $this->token);
        if (count($parts) < 2) {
            return [
                'status' => 'invalid_format',
                'is_expired' => true,
                'message' => 'Token is not a valid JWT format.',
                'exp_date' => null,
            ];
        }

        $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
        if (!$payload || !isset($payload['exp'])) {
            return [
                'status' => 'unknown',
                'is_expired' => false,
                'message' => 'Token format recognized, but expiration date is unknown.',
                'exp_date' => null,
            ];
        }

        $expTime = (int) $payload['exp'];
        $isExpired = $expTime < time();
        $expDate = date('Y-m-d H:i:s', $expTime);

        return [
            'status' => $isExpired ? 'expired' : 'valid',
            'is_expired' => $isExpired,
            'exp_timestamp' => $expTime,
            'exp_date' => $expDate,
            'merchant_id' => $payload['merchant_id'] ?? null,
            'message' => $isExpired
                ? "Token expired on {$expDate}. Please generate a new token."
                : "Token is active (expires on {$expDate}).",
        ];
    }

    /**
     * Issue a brand new access token via OAuth 2.0 (password grant)
     * Endpoint: /aladdin/api/v1/issue-token
     */
    public function issueToken(?string $clientId = null, ?string $clientSecret = null, ?string $username = null, ?string $password = null): array
    {
        $clientId = $clientId ?: ($this->courier->api_key ?? '');
        $clientSecret = $clientSecret ?: ($this->courier->secret_key ?? '');
        $username = $username ?: ($this->courier->username ?? '');
        $password = $password ?: ($this->courier->password ?? '');

        if (empty($clientId) || empty($clientSecret) || empty($username) || empty($password)) {
            return [
                'status' => false,
                'message' => 'Client ID, Client Secret, Username (Email), and Password are all required to issue a Pathao token.',
            ];
        }

        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($this->baseUrl . '/api/v1/issue-token', [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'grant_type' => 'password',
                    'username' => $username,
                    'password' => $password,
                ]);

            $result = $response->json();

            if ($response->successful() && !empty($result['access_token'])) {
                $expiresIn = (int) ($result['expires_in'] ?? 432000);
                $expiresAt = Carbon::now()->addSeconds($expiresIn);

                $updateData = [
                    'token' => $result['access_token'],
                    'refresh_token' => $result['refresh_token'] ?? null,
                    'token_expires_at' => $expiresAt,
                    'api_key' => $clientId,
                    'secret_key' => $clientSecret,
                    'username' => $username,
                    'password' => $password,
                ];

                Courierapi::where('type', 'pathao')->update($updateData);
                $this->reloadConfig();
                Cache::flush();

                return [
                    'status' => true,
                    'message' => 'Pathao token issued successfully! Active until ' . $expiresAt->format('Y-m-d H:i:s'),
                    'access_token' => $result['access_token'],
                    'expires_at' => $expiresAt->format('Y-m-d H:i:s'),
                ];
            }

            $errMsg = $result['message'] ?? ($result['error'] ?? 'Failed to issue Pathao access token');
            if (isset($result['error_description'])) {
                $errMsg .= ': ' . $result['error_description'];
            }
            Log::error('Pathao issueToken error response: ' . $response->body());
            return ['status' => false, 'message' => $errMsg];
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, 'cURL error 28') || str_contains($msg, 'timed out')) {
                if (str_contains($this->baseUrl, 'sandbox')) {
                    $msg = 'Pathao Sandbox server (courier-api-sandbox.pathao.com) timed out (origin server is offline / Cloudflare 522). Please use Production URL (https://api-hermes.pathao.com) with your live merchant credentials.';
                } else {
                    $msg = 'Connection to Pathao server timed out. Please check your network or try again.';
                }
            }
            Log::error('Pathao issueToken exception: ' . $e->getMessage());
            return ['status' => false, 'message' => $msg];
        }
    }

    /**
     * Refresh access token using refresh_token
     * Endpoint: /aladdin/api/v1/issue-token
     */
    public function refreshToken(): array
    {
        if (!$this->courier || empty($this->courier->refresh_token) || empty($this->courier->api_key) || empty($this->courier->secret_key)) {
            return ['status' => false, 'message' => 'Refresh token or client credentials are not available.'];
        }

        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($this->baseUrl . '/api/v1/issue-token', [
                    'client_id' => $this->courier->api_key,
                    'client_secret' => $this->courier->secret_key,
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $this->courier->refresh_token,
                ]);

            $result = $response->json();

            if ($response->successful() && !empty($result['access_token'])) {
                $expiresIn = (int) ($result['expires_in'] ?? 432000);
                $expiresAt = Carbon::now()->addSeconds($expiresIn);

                $updateData = [
                    'token' => $result['access_token'],
                    'refresh_token' => $result['refresh_token'] ?? $this->courier->refresh_token,
                    'token_expires_at' => $expiresAt,
                ];

                Courierapi::where('type', 'pathao')->update($updateData);
                $this->reloadConfig();
                Cache::flush();

                return [
                    'status' => true,
                    'message' => 'Pathao token refreshed successfully! Active until ' . $expiresAt->format('Y-m-d H:i:s'),
                    'access_token' => $result['access_token'],
                    'expires_at' => $expiresAt->format('Y-m-d H:i:s'),
                ];
            }

            Log::warning('Pathao refreshToken failed: ' . $response->body());
            return ['status' => false, 'message' => $result['message'] ?? 'Failed to refresh Pathao token'];
        } catch (\Exception $e) {
            Log::error('Pathao refreshToken exception: ' . $e->getMessage());
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Ensure the access token is valid, auto-refreshing if expired or expiring soon (within 24 hours)
     */
    public function ensureValidToken(): bool
    {
        $status = $this->getTokenStatus();

        // If active with more than 24 hours remaining, token is good to use
        if (!$status['is_expired'] && !empty($status['exp_timestamp'])) {
            $secondsRemaining = $status['exp_timestamp'] - time();
            if ($secondsRemaining > 86400) {
                return true;
            }
        }

        // Expired or expiring within 24 hours: Auto-refresh seamlessly via refresh_token
        if (!empty($this->courier->refresh_token)) {
            $res = $this->refreshToken();
            if ($res['status']) {
                return true;
            }
        }

        // Fallback: Re-issue via saved merchant credentials
        if (!empty($this->courier->api_key) && !empty($this->courier->secret_key) && !empty($this->courier->username) && !empty($this->courier->password)) {
            $res = $this->issueToken();
            if ($res['status']) {
                return true;
            }
        }

        return !$status['is_expired'];
    }

    protected function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Get List of Cities
     * Official Doc Endpoint: /aladdin/api/v1/city-list
     */
    public function getCities()
    {
        $this->ensureValidToken();

        if (empty($this->token)) {
            return [];
        }

        return Cache::remember('pathao_cities_' . md5($this->token), 86400, function () {
            try {
                // Official endpoint
                $response = Http::timeout(10)
                    ->withHeaders($this->headers())
                    ->get($this->baseUrl . '/api/v1/city-list');

                if ($response->successful()) {
                    return $response->json();
                }

                // Fallback to older endpoint if server requires country param
                $fallback = Http::timeout(10)
                    ->withHeaders($this->headers())
                    ->get($this->baseUrl . '/api/v1/countries/1/city-list');

                if ($fallback->successful()) {
                    return $fallback->json();
                }

                Log::warning('Pathao getCities failed: ' . $response->body());
                return [];
            } catch (\Exception $e) {
                Log::error('Pathao getCities exception: ' . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Get Merchant Store Info
     * Endpoint: /aladdin/api/v1/stores
     */
    public function getStores()
    {
        $this->ensureValidToken();

        if (empty($this->token)) {
            return [];
        }

        return Cache::remember('pathao_stores_' . md5($this->token), 3600, function () {
            try {
                $response = Http::timeout(10)
                    ->withHeaders($this->headers())
                    ->get($this->baseUrl . '/api/v1/stores');

                if ($response->successful()) {
                    return $response->json();
                }

                Log::warning('Pathao getStores failed: ' . $response->body());
                return [];
            } catch (\Exception $e) {
                Log::error('Pathao getStores exception: ' . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Get zones inside a particular city
     * Endpoint: /aladdin/api/v1/cities/{city_id}/zone-list
     */
    public function getZones($cityId)
    {
        $this->ensureValidToken();

        if (empty($this->token) || empty($cityId)) {
            return [];
        }

        return Cache::remember('pathao_zones_' . $cityId . '_' . md5($this->token), 86400, function () use ($cityId) {
            try {
                $response = Http::timeout(10)
                    ->withHeaders($this->headers())
                    ->get($this->baseUrl . '/api/v1/cities/' . $cityId . '/zone-list');

                if ($response->successful()) {
                    return $response->json();
                }

                Log::warning("Pathao getZones({$cityId}) failed: " . $response->body());
                return [];
            } catch (\Exception $e) {
                Log::error("Pathao getZones({$cityId}) exception: " . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Get areas inside a particular zone
     * Endpoint: /aladdin/api/v1/zones/{zone_id}/area-list
     */
    public function getAreas($zoneId)
    {
        $this->ensureValidToken();

        if (empty($this->token) || empty($zoneId)) {
            return [];
        }

        return Cache::remember('pathao_areas_' . $zoneId . '_' . md5($this->token), 86400, function () use ($zoneId) {
            try {
                $response = Http::timeout(10)
                    ->withHeaders($this->headers())
                    ->get($this->baseUrl . '/api/v1/zones/' . $zoneId . '/area-list');

                if ($response->successful()) {
                    return $response->json();
                }

                Log::warning("Pathao getAreas({$zoneId}) failed: " . $response->body());
                return [];
            } catch (\Exception $e) {
                Log::error("Pathao getAreas({$zoneId}) exception: " . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Create a New Order
     * Endpoint: /aladdin/api/v1/orders
     */
    public function createOrder(Order $order, array $params = []): array
    {
        if (!$this->isConfigured()) {
            return ['status' => false, 'message' => 'Pathao courier API is not configured or is inactive.'];
        }

        $this->ensureValidToken();

        if (empty($this->token)) {
            return [
                'status' => false,
                'message' => 'Pathao Bearer token is missing or expired. Please connect your credentials in Courier Settings.',
            ];
        }

        $order->loadMissing(['shipping', 'orderdetails']);
        $shipping = $order->shipping;

        if (!$shipping || empty($shipping->phone)) {
            return ['status' => false, 'message' => "Order #{$order->invoice_id} is missing shipping customer phone number."];
        }

        // Determine store ID: from params or first available store
        $storeId = $params['store_id'] ?? null;
        if (empty($storeId)) {
            $stores = $this->getStores();
            if (isset($stores['data']['data'][0]['store_id'])) {
                $storeId = $stores['data']['data'][0]['store_id'];
            }
        }

        if (empty($storeId)) {
            return ['status' => false, 'message' => 'Pathao Store is required. Please select a valid store.'];
        }

        $cityId = $params['city_id'] ?? null;
        $zoneId = $params['zone_id'] ?? null;
        $areaId = $params['area_id'] ?? null;

        if (empty($cityId) || empty($zoneId)) {
            return [
                'status' => false,
                'message' => "Pathao strictly requires recipient city and zone for Order #{$order->invoice_id}.",
            ];
        }

        $firstItem = $order->orderdetails ? $order->orderdetails->first() : null;
        $itemDesc = $firstItem ? $firstItem->product_name : 'Ecommerce parcel';

        $dueAmount = (int) round($order->amount - ($order->paid_partial_payment_amount ?? 0));
        if ($dueAmount < 0) {
            $dueAmount = 0;
        }

        $cleanPhone = $this->formatPhone($shipping->phone);
        if (strlen($cleanPhone) < 11) {
            return ['status' => false, 'message' => "Order #{$order->invoice_id} customer phone number is invalid ({$shipping->phone}). Must be 11 digits."];
        }

        // Clamp address length strictly to 10 - 220 characters as per Pathao doc
        $cleanAddress = substr($this->formatAddress($shipping->address, $order->city), 0, 220);

        // Pathao Official Create Order Payload (Sender info is bound to store_id)
        $payload = [
            'store_id' => (int) $storeId,
            'merchant_order_id' => (string) $order->invoice_id,
            'recipient_name' => substr($shipping->name ?: 'Customer', 0, 100),
            'recipient_phone' => $cleanPhone,
            'recipient_address' => $cleanAddress,
            'delivery_type' => (int) ($params['delivery_type'] ?? 48), // 48: Normal, 12: On Demand
            'item_type' => (int) ($params['item_type'] ?? 2),          // 1: Document, 2: Parcel
            'special_instruction' => substr($params['special_instruction'] ?? ($order->note ?: 'Handle with care'), 0, 250),
            'item_quantity' => $order->orderdetails ? max(1, (int) $order->orderdetails->sum('qty')) : 1,
            'item_weight' => max(0.5, min(10.0, (float) ($params['item_weight'] ?? 0.5))),
            'amount_to_collect' => $dueAmount,
            'item_description' => substr($itemDesc, 0, 250),
        ];

        // Only include optional geolocation fields if present (Never send null as per doc)
        if (!empty($cityId)) {
            $payload['recipient_city'] = (int) $cityId;
        }
        if (!empty($zoneId)) {
            $payload['recipient_zone'] = (int) $zoneId;
        }
        if (!empty($areaId)) {
            $payload['recipient_area'] = (int) $areaId;
        }
        if (!empty($shipping->secondary_phone)) {
            $cleanSecondary = $this->formatPhone($shipping->secondary_phone);
            if (strlen($cleanSecondary) === 11) {
                $payload['recipient_secondary_phone'] = $cleanSecondary;
            }
        }

        try {
            $response = Http::timeout(15)
                ->withHeaders($this->headers())
                ->post($this->baseUrl . '/api/v1/orders', $payload);

            $result = $response->json();

            if ($response->successful() && isset($result['data']['consignment_id'])) {
                $consignmentId = $result['data']['consignment_id'];

                $order->order_status = 5; // In Courier
                $note = trim($order->admin_note ?? '');
                $order->admin_note = $note ? $note . " | Pathao: {$consignmentId}" : "Pathao: {$consignmentId}";
                $order->save();

                return [
                    'status' => true,
                    'consignment_id' => $consignmentId,
                    'message' => "Order #{$order->invoice_id} dispatched to Pathao. Consignment ID: {$consignmentId}",
                ];
            }

            $errMsg = $result['message'] ?? 'Failed to dispatch order to Pathao';
            if (isset($result['errors'])) {
                $errDetails = is_array($result['errors']) ? implode(', ', array_map(function($k, $v) {
                    return "$k: " . (is_array($v) ? implode(';', $v) : $v);
                }, array_keys($result['errors']), $result['errors'])) : json_encode($result['errors']);
                $errMsg .= " ({$errDetails})";
            }

            Log::error("Pathao dispatch failed for Order #{$order->invoice_id}: " . $response->body());
            return ['status' => false, 'message' => $errMsg];
        } catch (\Exception $e) {
            Log::error("Pathao dispatch exception for Order #{$order->invoice_id}: " . $e->getMessage());
            return ['status' => false, 'message' => 'Connection to Pathao failed: ' . $e->getMessage()];
        }
    }

    /**
     * Get Order Short Info
     * Endpoint: /aladdin/api/v1/orders/{consignment_id}/info
     */
    public function getOrderInfo(string $consignmentId): array
    {
        $this->ensureValidToken();

        if (empty($this->token)) {
            return ['status' => false, 'message' => 'Pathao token is missing or expired.'];
        }

        try {
            $response = Http::timeout(10)
                ->withHeaders($this->headers())
                ->get($this->baseUrl . '/api/v1/orders/' . $consignmentId . '/info');

            if ($response->successful()) {
                return ['status' => true, 'data' => $response->json()];
            }

            return ['status' => false, 'message' => $response->body()];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Price Calculation API
     * Endpoint: /aladdin/api/v1/merchant/price-plan
     */
    public function calculatePrice(int $storeId, int $cityId, int $zoneId, float $weight = 0.5, int $deliveryType = 48, int $itemType = 2): array
    {
        $this->ensureValidToken();

        if (empty($this->token)) {
            return ['status' => false, 'message' => 'Pathao token is missing or expired.'];
        }

        try {
            $response = Http::timeout(10)
                ->withHeaders($this->headers())
                ->post($this->baseUrl . '/api/v1/merchant/price-plan', [
                    'store_id' => $storeId,
                    'item_type' => $itemType,
                    'delivery_type' => $deliveryType,
                    'item_weight' => max(0.5, min(10.0, $weight)),
                    'recipient_city' => $cityId,
                    'recipient_zone' => $zoneId,
                ]);

            if ($response->successful()) {
                return ['status' => true, 'data' => $response->json()];
            }

            return ['status' => false, 'message' => $response->body()];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function formatPhone(?string $phone): string
    {
        if (empty($phone)) return '';
        $clean = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($clean, '8801') && strlen($clean) === 13) {
            $clean = substr($clean, 2);
        }
        return $clean;
    }

    public function formatAddress(?string $address, ?string $fallback = ''): string
    {
        $addr = trim($address ?? '');
        if (strlen($addr) < 10 && !empty($fallback)) {
            $addr = trim($addr . ', ' . $fallback);
        }
        if (strlen($addr) < 10) {
            $addr = str_pad($addr, 10, ' ');
        }
        return $addr;
    }
}
