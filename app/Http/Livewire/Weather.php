<?php

namespace App\Http\Livewire;

use App\DTO\WeatherDto;
use Livewire\Component;
use App\Services\GetWeather;

class Weather extends Component
{
    public string $location = '';
    
    public function render()
    {
        return view('livewire.weather');
    }

    public function search() : void
    {
        $weather = (new GetWeather($this->location))->run();

        $weatherDto = (New WeatherDto($weather));

        // $this->emit('weatherFetched', $weatherDto);

        }
    
}
