<?php

namespace App\Http\Controllers;

use App\Http\Resources\NumVerifyResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PhoneValidationController extends Controller
{
    public function validate(Request $request)
    {
        $request->validate([
            'number' => 'required|string',
        ]);

        $response = Http::get(config('services.numverify.endpoint'), [
            'access_key'   => config('services.numverify.key'),
            'number'       => $request->input('number'),
            'country_code' => $request->input('country_code', ''), // opcional
            'format'       => 1,
        ]);

        if ($response->failed() || isset($response['error'])) {
            return response()->json([
                'success' => false,
                'message' => 'Falha ao validar número.',
                'error'   => $response->json()['error'] ?? null,
            ], 400);
        }

        return new NumVerifyResource($response->json());
    }
}
