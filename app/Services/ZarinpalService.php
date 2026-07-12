<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZarinpalService
{
    protected string $merchant;
    protected bool $sandbox;

    public function __construct()
    {
        $this->merchant = env('ZARINPAL_MERCHANT_ID');
        $this->sandbox = env('ZARINPAL_SANDBOX', true);
    }

    protected function baseUrl(): string
    {
        return $this->sandbox
            ? 'https://sandbox.zarinpal.com/pg/v4/payment'
            : 'https://api.zarinpal.com/pg/v4/payment';
    }

    /**
     * ایجاد درخواست پرداخت
     */
    public function request(int $amount, string $callbackUrl, string $description): array
    {
        $response = Http::post($this->baseUrl() . '/request.json', [
            'merchant_id' => $this->merchant,
            'amount' => $amount . 0,
            'callback_url' => $callbackUrl,
            'description' => $description,
        ]);

        return $response->json();
    }

    /**
     * تایید پرداخت
     */
    public function verify(int $amount, string $authority): array
    {
        $response = Http::post($this->baseUrl() . '/verify.json', [
            'merchant_id' => $this->merchant,
            'amount' => $amount,
            'authority' => $authority,
        ]);

        return $response->json();
    }

    /**
     * ساخت لینک انتقال به درگاه
     */
    public function redirectUrl(string $authority): string
    {
        return $this->sandbox
            ? "https://sandbox.zarinpal.com/pg/StartPay/{$authority}"
            : "https://www.zarinpal.com/pg/StartPay/{$authority}";
    }
}