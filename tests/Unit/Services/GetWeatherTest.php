<?php

namespace Tests\Unit\Services;

use App\Services\GetWeather;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class GetWeatherTest extends TestCase
{
    public function test_run_returns_weather_data()
    {
        // Mock GuzzleHttp\Client
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('get')
            ->once()
            ->andReturn(new Response(200, [], json_encode(['some' => 'weather data'])));

        // Test the service
        $service = GetWeather::getInstance('api_key');
        $service->setClient($clientMock);

        $result = $service->run('New York', 'm');

        $this->assertEquals(json_encode(['some' => 'weather data']), $result);
    }

    public function test_run_returns_false_on_api_error()
    {
        // Mock GuzzleHttp\Client
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('get')
            ->once()
            ->andReturn(new Response(200, [], json_encode(['success' => false, 'error' => ['info' => 'Invalid access key']])));

        // Mock Illuminate\Support\Facades\Log
        Log::shouldReceive('warning')
            ->once()
            ->with('Weatherstack API error: {"success":false,"error":{"info":"Invalid access key"}}');

        // Test the service
        $service = new GetWeather('api_key');
        $service->setClient($clientMock);

        $result = $service->run('New York', 'm');

        $this->assertFalse($result);
    }

    public function test_run_returns_false_on_http_error()
    {
        // Mock GuzzleHttp\Client
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('get')
            ->once()
            ->andReturn(new Response(500, [], 'Internal Server Error'));

        // Test the service
        $service = new GetWeather('api_key');
        $service->setClient($clientMock);

        $result = $service->run('New York', 'm');

        $this->assertFalse($result);
    }
}
