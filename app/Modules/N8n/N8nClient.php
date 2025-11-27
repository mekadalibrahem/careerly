<?php


namespace App\Modules\N8n;

use Illuminate\Support\Facades\Http;
use Exception;

class N8nClient
{
    public function call(string $webhookPath, array $payload): array
    {
        $url = config('n8n.base_url') . 'webhook/' . $webhookPath;

        try {
            $response = Http::timeout(30)->post($url, $payload);

            if (!$response->successful()) {
                throw new Exception("N8n Error: " . $response->body());
            }

            return $response->json();
        } catch (Exception $e) {
            report($e);
            return ['error' => $e->getMessage()];
        }
    }
}
