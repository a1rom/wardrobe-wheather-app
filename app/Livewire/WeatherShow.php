<?php

namespace App\Livewire;

use App\DTO\WeatherDto;
use Livewire\Component;
use App\Services\GetWeather;

class WeatherShow extends Component
{
    public string $locationSearch = '';

    public string $location = '';
    
    public function render() : \Illuminate\View\View
    {
        return view('livewire.weather-show');
    }

    public function search() : void
    {
        $weather = (new GetWeather($this->locationSearch))->run();

        if($weather === false) {
            $this->addError('locationSearch', 'Location not found');
            return;
        }

        $this->resetValidation();

        $weatherDto = (New WeatherDto())->fromJson($weather);

        $this->location = $weatherDto->location_name;

        // $this->emit('weatherFetched', $weatherDto);
    }
}
