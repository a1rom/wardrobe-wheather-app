<?php

namespace App\Actions;

use App\DTO\WeatherDto;

class WardrobeSuggestionsGet
{
    private WeatherDto $weatherDto;
    
    /**
     * @var array<string, array<string, array<string, array<mixed>>>>
     */
    private array $clothes = [
        'head' => [
            'warm hat' => [
                'keywords' => [],
                'temperature' => ['min' => -99, 'max' => 0],
                'wind' => ['min' => 0, 'max' => 99],
            ],
            'hat' => [
                'keywords' => [],
                'temperature' => ['min' => 0, 'max' => 15],
                'wind' => ['min' => 5, 'max' => 99],
            ],
            'cap' => [
                'keywords' => [],
                'temperature' => ['min' => 10, 'max' => 99],
                'wind' => ['min' => 0, 'max' => 10],
            ],
        ],
        'body' => [
            'warm coat' => [
                'keywords' => ['rain', 'snow'],
                'temperature' => ['min' => -99, 'max' => 0],
                'wind' => ['min' => 0, 'max' => 99],
            ],
            'coat' => [
                'keywords' => ['rain', 'snow'],
                'temperature' => ['min' => -5, 'max' => 15],
                'wind' => ['min' => 0, 'max' => 99],
            ],
            'jacket' => [
                'keywords' => [],
                'temperature' => ['min' => 0, 'max' => 15],
                'wind' => ['min' => 0, 'max' => 20],
            ],
        ],
        'footwear' => [
            'flip flops' => [
                'keywords' => ['sun'],
                'temperature' => ['min' => 20, 'max' => 99],
                'wind' => ['min' => 0, 'max' => 10],
            ],
            'sneakers' => [
                'keywords' => [],
                'temperature' => ['min' => 5, 'max' => 20],
                'wind' => ['min' => 0, 'max' => 99],
            ],
            'boots' => [
                'keywords' => ['rain', 'snow'],
                'temperature' => ['min' => -99, 'max' => 5],
                'wind' => ['min' => 0, 'max' => 99],
            ],
        ],
    ];
    
    /**
     * @param WeatherDto $weatherDto
     * 
     * @return void
     */
    public function __construct(WeatherDto $weatherDto)
    {
        $this->weatherDto = $weatherDto;
    }

    /**
     * @return array<string, array<string>>
     */
    public function run() : array
    {
        $suggestions = [];

        foreach($this->clothes as $clothesType => $clothes) {
            foreach($clothes as $clothesName => $clothesData) {
                if($this->weatherDto->get('current.temperature') >= $clothesData['temperature']['min'] && $this->weatherDto->get('current.temperature') <= $clothesData['temperature']['max']) {
                    if($this->weatherDto->get('current.wind_speed') >= $clothesData['wind']['min'] && $this->weatherDto->get('current.wind_speed') <= $clothesData['wind']['max']) {
                        $suggestions[$clothesType][] = $clothesName;
                    }
                }
            }
        }

        return $suggestions;
    }
}
