<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PhoneValidationTest extends TestCase
{
    public function test_it_validates_a_phone_number()
    {
        // Fake response da API externa
        Http::fake([
            config('services.numverify.endpoint') . '*' => Http::response([
                'valid' => true,
                'number' => '14158586273',
                'local_format' => '4158586273',
                'international_format' => '+14158586273',
                'country_prefix' => '+1',
                'country_code' => 'US',
                'country_name' => 'United States of America',
                'location' => 'Novato',
                'carrier' => 'AT&T Mobility',
                'line_type' => 'mobile',
            ], 200),
        ]);

        // Dispara a requisição
        $response = $this->getJson('/api/v1/validate-number?number=14158586273');

        // Valida resultado esperado
        $response->assertOk()
            ->assertJsonFragment([
                'valid' => true,
                'number' => '14158586273',
                'country_name' => 'United States of America',
                'carrier' => 'AT&T Mobility',
            ]);
    }

    public function test_it_requires_a_number()
    {
        $response = $this->getJson('/api/v1/validate-number');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['number']);
    }
}
