<?php

namespace App\Services;

use App\Http\Resources\NumVerifyResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Http;

class NumVerifyService
{
    public function validate(string $number, ?string $country_code = ''): array
    {
        $response = Http::get(config('services.numverify.endpoint'), [
            'access_key'   => config('services.numverify.key'),
            'number'       => $number,
            'country_code' => $country_code,
            'format'       => 1,
        ]);

        if ($response->failed() || isset($response['error'])) {
            return [
                'error'   => $response->json()['error'] ?? null,
                'success' => false,
                'message' => 'Falha ao validar número.',
            ];
        }

        return $response->json();
    }
}
