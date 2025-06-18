<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PhoneValidationTest extends TestCase
{
    protected function fakeNumVerifyApiResponse(): void
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
    }


    public function test_it_validates_a_phone_number()
    {
        $this->fakeNumVerifyApiResponse();

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

    public function test_country_code_must_be_two_letters(): void
    {
        $response = $this->getJson('/api/v1/validate-number?number=14158586273&country_code=USA');

        $response->assertStatus(422)
            ->assertJsonValidationErrors('country_code');
    }

    public function test_country_code_cannot_be_numeric(): void
    {
        $response = $this->getJson('/api/v1/validate-number?number=14158586273&country_code=55');

        $response->assertStatus(422)
            ->assertJsonValidationErrors('country_code');
    }


    public function test_number_cannot_be_empty(): void
    {
        $response = $this->getJson('/api/v1/validate-number?number=');

        $response->assertStatus(422)
            ->assertJsonValidationErrors('number');
    }
}
