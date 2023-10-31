<?php

namespace App\Livewire;

use App\DTO\WeatherDto;
use Livewire\Component;
use App\Services\GetWeather;
use App\Actions\WardrobeSuggestionsGet;

class WeatherShow extends Component
{
    public string $locationSearch = '';

    public string $units = 'm';

    public string $location = '';

    /**
     * @var array<string, mixed>
     */
    public array $weather;

    /**
     * @var array<string, mixed>
     */
    public array $wardrobeSuggestions;
    
    public function render() : \Illuminate\View\View
    {
        return view('livewire.weather-show');
    }

    public function search() : void
    {
        $weather = (new GetWeather($this->locationSearch, $this->units))
            ->run();

        if($weather === false) {
            $this->addError('locationSearch', 'Location not found');
            return;
        }

        $this->resetValidation();

        $weatherDto = (New WeatherDto())->fromJson($weather);

        if($weatherDto === false) {
            $this->addError('technicalIssue', 'Technical issue, please try again later');
            return;
        }

        $this->wardrobeSuggestions = (new WardrobeSuggestionsGet())->run($weatherDto);

        $this->weather = $weatherDto->toArray();
        
        $this->dispatch('weatherFetched');
    }
}
