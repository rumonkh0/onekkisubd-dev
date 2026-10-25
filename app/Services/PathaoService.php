<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Courierapi;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderDetails;
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
        $this->courier = Courierapi::where(['status' => 1, 'type' => 'pathao'])->first();
        $this->baseUrl = $this->courier && !empty($this->courier->url)
            ? rtrim($this->courier->url, '/')
            : 'https://api-hermes.pathao.com/aladdin';
        $this->token = $this->courier ? trim($this->courier->token ?? '') : null;
    }

    public function isConfigured(): bool
    {
        return !empty($this->courier) && !empty($this->token);
    }

    public function getCourier(): ?Courierapi
    {
        return $this->courier;
    }

    public function getTokenStatus(): array
    {
        if (empty($this->token)) {
            return [
                'status' => 'missing',
                'is_expired' => true,
                'message' => 'Pathao access token is missing.',
                'exp_date' => null,
            ];
        }

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
                'message' => 'Could not determine token expiration date.',
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
                ? "Token expired on {$expDate}. Please generate and save a new token."
                : "Token is active (expires on {$expDate}).",
        ];
    }

    protected function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    public function getCities()
    {
        if (!$this->isConfigured()) {
            return [];
        }

        return Cache::remember('pathao_cities_' . md5($this->token), 86400, function () {
            try {
                $response = Http::timeout(5)
                    ->withHeaders($this->headers())
                    ->get($this->baseUrl . '/api/v1/countries/1/city-list');

                if ($response->successful()) {
                    return $response->json();
                }

                Log::warning('Pathao getCities failed: ' . $response->body());
                return [];
            } catch (\Exception $e) {
                Log::error('Pathao getCities exception: ' . $e->getMessage());
                return [];
            }
        });
    }

    public function getStores()
    {
        if (!$this->isConfigured()) {
            return [];
        }

        return Cache::remember('pathao_stores_' . md5($this->token), 3600, function () {
            try {
                $response = Http::timeout(5)
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

    public function getZones($cityId)
    {
        if (!$this->isConfigured() || empty($cityId)) {
            return [];
        }

        return Cache::remember('pathao_zones_' . $cityId . '_' . md5($this->token), 86400, function () use ($cityId) {
            try {
                $response = Http::timeout(5)
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

    public function getAreas($zoneId)
    {
        if (!$this->isConfigured() || empty($zoneId)) {
            return [];
        }

        return Cache::remember('pathao_areas_' . $zoneId . '_' . md5($this->token), 86400, function () use ($zoneId) {
            try {
                $response = Http::timeout(5)
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

    public function createOrder(Order $order, array $params = []): array
    {
        if (!$this->isConfigured()) {
            return ['status' => false, 'message' => 'Pathao courier API is not configured or is inactive.'];
        }

        $tokenStatus = $this->getTokenStatus();
        if (!empty($tokenStatus['is_expired'])) {
            return [
                'status' => false,
                'message' => 'Pathao Bearer token has expired. Please update the token in Courier API Settings.',
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

        $setting = GeneralSetting::first();
        $contact = Contact::first();
        $senderName = $setting->name ?? 'OnekkisuBD';
        $senderPhone = $contact->phone ?? '01850945080';

        $firstItem = $order->orderdetails ? $order->orderdetails->first() : null;
        $itemDesc = $firstItem ? $firstItem->product_name : 'Ecommerce parcel';

        $dueAmount = round($order->amount - ($order->paid_partial_payment_amount ?? 0));
        if ($dueAmount < 0) {
            $dueAmount = 0;
        }

        $cleanPhone = $this->formatPhone($shipping->phone);
        if (strlen($cleanPhone) < 11) {
            return ['status' => false, 'message' => "Order #{$order->invoice_id} customer phone number is invalid ({$shipping->phone}). Must be 11 digits."];
        }

        $cleanAddress = $this->formatAddress($shipping->address, $order->city);

        $payload = [
            'store_id' => (int) $storeId,
            'merchant_order_id' => (string) $order->invoice_id,
            'sender_name' => $senderName,
            'sender_phone' => $this->formatPhone($senderPhone),
            'recipient_name' => $shipping->name ?: 'Customer',
            'recipient_phone' => $cleanPhone,
            'recipient_address' => $cleanAddress,
            'recipient_city' => (int) $cityId,
            'recipient_zone' => (int) $zoneId,
            'delivery_type' => 48,
            'item_type' => 2,
            'special_instruction' => $params['special_instruction'] ?? ($order->note ?: 'Handle with care'),
            'item_quantity' => $order->orderdetails ? max(1, $order->orderdetails->sum('qty')) : 1,
            'item_weight' => 0.5,
            'amount_to_collect' => $dueAmount,
            'item_description' => $itemDesc,
        ];

        if (!empty($areaId)) {
            $payload['recipient_area'] = (int) $areaId;
        }

        try {
            $response = Http::timeout(10)
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
