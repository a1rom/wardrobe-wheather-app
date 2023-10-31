<?php

namespace Tests\DTO;

use App\DTO\WeatherDto;
use PHPUnit\Framework\TestCase;

class WeatherDtoTest extends TestCase
{
    public function testFromJson(): void
    {
        $json = json_encode([
            'location' => [
                'name' => 'London',
                'country' => 'UK',
                'localtime' => '2022-01-01 12:00:00',
                'localtime_epoch' => 1641052800,
            ],
            'current' => [
                'temperature' => 20,
                'weather_icons' => ['icon1', 'icon2'],
                'weather_descriptions' => ['Sunny', 'Clear'],
                'wind_speed' => 10,
                'wind_dir' => 'N',
                'humidity' => 50,
            ],
        ]);

        $weatherDto = new WeatherDto();
        $weatherDto = $weatherDto->fromJson($json);

        $this->assertInstanceOf(WeatherDto::class, $weatherDto);
    }

    public function testToArray(): void
    {
        $data = [
            'location' => [
                'name' => 'London',
                'country' => 'UK',
                'localtime' => '2022-01-01 12:00:00',
                'localtime_epoch' => 1641052800,
            ],
            'current' => [
                'temperature' => 20,
                'weather_icons' => ['icon1', 'icon2'],
                'weather_descriptions' => ['Sunny', 'Clear'],
                'wind_speed' => 10,
                'wind_dir' => 'N',
                'humidity' => 50,
            ],
        ];

        $weatherDto = new WeatherDto();
        $weatherDto = $weatherDto->fromArray($data);

        $this->assertEquals($data, $weatherDto->toArray());
    }
}
