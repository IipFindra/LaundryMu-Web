<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    /**
     * Send a WhatsApp message using Fonnte API.
     *
     * @param string $phone
     * @param string $message
     * @return array
     */
    public function sendMessage(string $phone, string $message): array
    {
        $token = config('services.fonnte.token') ?? env('FONNTE_TOKEN');
        $target = $this->formatPhoneNumber($phone);

        if (empty($token)) {
            Log::error('Fonnte API Token is not configured in .env or services.php');
            return [
                'success' => false,
                'message' => 'Fonnte API Token is missing.',
            ];
        }

        try {
            Log::info("Sending WhatsApp OTP via Fonnte to: {$target}");

            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->asForm()->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62',
            ]);

            $body = $response->json();

            if ($response->successful() && isset($body['status']) && $body['status'] === true) {
                Log::info("WhatsApp message successfully sent via Fonnte to {$target}. Response: " . json_encode($body));
                return [
                    'success' => true,
                    'message' => 'Message successfully sent.',
                    'response' => $body,
                ];
            }

            Log::error("Fonnte API error response for {$target}: " . json_encode($body));
            return [
                'success' => false,
                'message' => $body['reason'] ?? 'Failed to send WhatsApp message via Fonnte.',
                'response' => $body,
            ];

        } catch (\Exception $e) {
            Log::error("Fonnte API exception while sending to {$target}: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Standardize Indonesian phone numbers to Fonnte expected format (starts with 62 or 08).
     * Fonnte is flexible, but converting '+' and leading '0' to standard country prefix is most reliable.
     *
     * @param string $phone
     * @return string
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Remove any non-numeric characters (like spaces, dashes, or +)
        $cleaned = preg_replace('/[^0-9]/', '', $phone);

        // Convert leading '0' to '62'
        if (str_starts_with($cleaned, '0')) {
            return '62' . substr($cleaned, 1);
        }

        return $cleaned;
    }
}
