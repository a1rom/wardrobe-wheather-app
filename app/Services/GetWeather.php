<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GetWeather
{
    private static ?GetWeather $instance = null;

    private string $apiKey;

    private Client $client;
    
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client();
    }

    public static function getInstance(string $apiKey): GetWeather
    {
        if (self::$instance === null) {
            self::$instance = new self($apiKey);
        }

        return self::$instance;
    }

    public function run(string $location, string $units) : string|false
    {
        $response = $this->client->get('http://api.weatherstack.com/current', [
            'query' => [
                'access_key' => $this->apiKey,
                'query' => $location,
                'units' => $units,
            ],
        ]);
        
        if($response->getStatusCode() == 200) {
            $content = $response->getBody()->getContents();
            $data = json_decode($content, true);

            if(array_key_exists('success', $data) && $data['success'] === false) {
                Log::warning('Weatherstack API error: ' . json_encode($data));
                return false;
            }

            return $content;
        }

        return false;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }
}
