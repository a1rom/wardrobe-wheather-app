<?php

namespace App\Livewire;

use App\DTO\WeatherDto;
use Livewire\Component;
use App\Services\GetWeather;

class WeatherShow extends Component
{
    public function render() : \Illuminate\View\View
    {
        return view('livewire.weather-show');
    }

    public function search() : void
    {
        $weather = (new GetWeather($this->location))->run();

        if($weather === false) {
            // $this->addError('location', 'Location not found');
            return;
        }

        $weatherDto = (New WeatherDto())->fromJson($weather);

xdebug_break();
        $location = $weatherDto->location_name;

xdebug_break();
        // $this->emit('weatherFetched', $weatherDto);

    }
}
