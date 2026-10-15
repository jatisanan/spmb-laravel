<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmailValidationService
{
    public function validate(string $email): bool
    {
        // 1. Format dasar
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // 2. Cek DNS MX (gratis, selalu jalan)
        $domain = substr(strrchr($email, '@'), 1);
        $hasMx = checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A');

        if (!$hasMx) {
            Log::info("Email domain tidak punya MX: {$domain}");
            return false;
        }

        // 3. Cek via Mailboxlayer (opsional)
        $apiKey = config('services.mailboxlayer.key');

        if (empty($apiKey)) {
            Log::warning('MAILBOX_LAYER_API_KEY kosong — skip API, pakai DNS saja.');
            return true;
        }

        try {
            $response = Http::timeout(5)->get('https://apilayer.net/api/check', [
                'access_key' => $apiKey,
                'email'      => $email,
                'smtp'       => 1,
                'format'     => 1,
            ]);

            // Kalau 401/104/5xx → fallback ke DNS (jangan blokir user)
            if ($response->status() === 401) {
                Log::warning('Mailboxlayer 401 Unauthorized — API key invalid/expired. Fallback ke DNS.');
                return true;
            }

            if (!$response->successful()) {
                Log::warning('Mailboxlayer HTTP error: ' . $response->status() . ' — fallback ke DNS.');
                return true;
            }

            $data = $response->json();

            if (($data['success'] ?? true) === false) {
                Log::warning('Mailboxlayer API error: ' . json_encode($data['error'] ?? []));
                return true;
            }

            // Cek disposable
            if (($data['disposable'] ?? false) === true) {
                return false;
            }

            $formatValid = $data['format_valid'] ?? false;
            $mxFound     = $data['mx_found'] ?? false;
            $smtpCheck   = $data['smtp_check'] ?? false;
            $score       = $data['score'] ?? 0;

            return $formatValid && $mxFound && $smtpCheck && $score >= 0.5;

        } catch (\Exception $e) {
            Log::warning('Mailboxlayer exception: ' . $e->getMessage() . ' — fallback ke DNS.');
            return true;
        }
    }
}