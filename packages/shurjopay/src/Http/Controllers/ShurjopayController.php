<?php

namespace shurjopayv2\ShurjopayLaravelPackage8\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ShurjopayController extends Controller
{
    protected $username;
    protected $password;
    protected $prefix;
    protected $return_url;
    protected $cancel_url;
    protected $base_url;

    public function __construct()
    {
        $this->username   = config('shurjopay.apiCredentials.username');
        $this->password   = config('shurjopay.apiCredentials.password');
        $this->prefix     = config('shurjopay.apiCredentials.prefix');
        $this->return_url = config('shurjopay.apiCredentials.return_url');
        $this->cancel_url = config('shurjopay.apiCredentials.cancel_url');
        $this->base_url   = rtrim(config('shurjopay.apiCredentials.base_url') ?? 'https://sandbox.shurjopayment.com', '/');
    }

    /**
     * Authenticate and get token from Shurjopay v2 API
     */
    protected function getToken()
    {
        try {
            $response = Http::timeout(10)->post($this->base_url . '/api/get_token', [
                'username' => $this->username,
                'password' => $this->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['token'] ?? null;
            }
        } catch (\Throwable $e) {
            Log::error('Shurjopay getToken error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Initiate checkout with Shurjopay
     */
    public function checkout($info)
    {
        $token = $this->getToken();

        if (!$token) {
            Log::error('Shurjopay token generation failed or gateway is not configured.');
            return redirect()->back()->with('error', 'Shurjopay gateway is currently unavailable.');
        }

        try {
            $payload = array_merge([
                'prefix'     => $this->prefix,
                'token'      => $token,
                'return_url' => $this->return_url,
                'cancel_url' => $this->cancel_url,
                'store_id'   => 1,
            ], $info);

            $response = Http::withToken($token)
                ->timeout(15)
                ->post($this->base_url . '/api/secret-pay', $payload);

            if ($response->successful()) {
                $resData = $response->json();
                if (!empty($resData['checkout_url'])) {
                    return redirect($resData['checkout_url']);
                }
            }

            Log::error('Shurjopay secret-pay response error: ' . $response->body());
        } catch (\Throwable $e) {
            Log::error('Shurjopay checkout exception: ' . $e->getMessage());
        }

        return redirect()->back()->with('error', 'Unable to redirect to Shurjopay payment.');
    }

    /**
     * Verify payment with Shurjopay
     */
    public function verify($order_id)
    {
        $token = $this->getToken();

        if (!$token) {
            Log::error('Shurjopay verify token generation failed.');
            return json_encode([['sp_code' => 1001, 'message' => 'Token generation failed']]);
        }

        try {
            $response = Http::withToken($token)
                ->timeout(15)
                ->post($this->base_url . '/api/verification', [
                    'order_id' => $order_id,
                ]);

            if ($response->successful()) {
                return $response->body();
            }

            Log::error('Shurjopay verification error: ' . $response->body());
        } catch (\Throwable $e) {
            Log::error('Shurjopay verify exception: ' . $e->getMessage());
        }

        return json_encode([['sp_code' => 1001, 'message' => 'Verification request failed']]);
    }
}
