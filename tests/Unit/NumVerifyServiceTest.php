<?php

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Services\NumVerifyService;
use App\Http\Resources\NumVerifyResource;

class NumVerifyServiceTest extends TestCase
{
    public function test_it_returns_resource_on_successful_validation(): void
    {
        Http::fake([
            '*' => Http::response([
                'valid' => true,
                'number' => '14158586273',
                'local_format' => '4158586273',
                'international_format' => '+14158586273',
                'country_prefix' => '+1',
                'country_code' => 'US',
                'country_name' => 'United States',
                'location' => 'Novato',
                'carrier' => 'AT&T',
                'line_type' => 'mobile',
            ])
        ]);

        $service = new NumVerifyService();
        $response = $service->validate('14158586273');

        $this->assertIsArray($response);
        $this->assertTrue($response['valid']);
    }

    public function test_it_returns_error_response_on_api_failure(): void
    {
        Http::fake([
            '*' => Http::response(['error' => ['code' => 210, 'info' => 'Invalid number']], 200)
        ]);

        $service = new NumVerifyService();
        $response = $service->validate('invalid');

        $this->assertFalse($response['success']);
        $this->assertEquals('Falha ao validar número.', $response['message']);
        $this->assertArrayHasKey('error', $response);
    }
}
