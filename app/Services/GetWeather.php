<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GetWeather
{
    private string $location;
    private string $apiKey;
    
    public function __construct(string $location)
    {
        $this->location = $location;
        $this->apiKey = env('WEATHERSTACK_API_KEY');
    }

    public function run(string $units = 'm') : string|false
    {
        $client = new Client();
        $response = $client->get('http://api.weatherstack.com/current', [
            'query' => [
                'access_key' => $this->apiKey,
                'query' => $this->location,
                'units' => $units,
            ],
        ]);
        
        if($response->getStatusCode() == 200) {
            $content = $response->getBody()->getContents();
            $data = json_decode($content, true);

            if($data['success'] === false) {
                Log::warning('Weatherstack API error: ' . json_encode($data));
                return false;
            }

            return $content;
        }

        return false;
    }
}
