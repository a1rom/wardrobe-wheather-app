<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GetWeather
{
    private string $location;
    private string $units;
    private string $apiKey;
    
    public function __construct(string $location, string $units = 'm')
    {
        $this->location = $location;
        $this->units = $units;
        $this->apiKey = env('WEATHERSTACK_API_KEY');
    }

    public function run() : string|false
    {
        $client = new Client();
        $response = $client->get('http://api.weatherstack.com/current', [
            'query' => [
                'access_key' => $this->apiKey,
                'query' => $this->location,
                'units' => $this->units,
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
}
