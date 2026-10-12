<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmailValidationService
{
    public function validate(string $email): bool
    {
        $apiKey = config('services.mailboxlayer.key') ?? env('MAILBOX_LAYER_API_KEY');

        if (empty($apiKey)) {
            Log::warning('Mailboxlayer API key kosong.');
            return true;
        }

        try {
            $response = Http::timeout(5)->get('https://apilayer.net/api/check', [
                'access_key' => $apiKey,
                'email'      => $email,
                'smtp'       => 1,
                'format'     => 1,
            ]);

            if (!$response->successful()) {
                Log::warning('Mailboxlayer HTTP error: ' . $response->status());
                return true;
            }

            $data = $response->json();

            if (isset($data['success']) && $data['success'] === false) {
                Log::warning('Mailboxlayer API error: ' . json_encode($data['error'] ?? []));
                return true;
            }

            $formatValid = $data['format_valid'] ?? false;
            $mxFound     = $data['mx_found'] ?? false;
            $smtpCheck   = $data['smtp_check'] ?? false;
            $score       = $data['score'] ?? 0;
            $disposable  = $data['disposable'] ?? false;

            if ($disposable) {
                return false;
            }

            return $formatValid && $mxFound && $smtpCheck && $score >= 0.5;

        } catch (\Exception $e) {
            Log::warning('Mailboxlayer exception: ' . $e->getMessage());
            return true;
        }
    }
}