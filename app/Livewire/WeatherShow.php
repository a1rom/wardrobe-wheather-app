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
        $weather = GetWeather::getInstance(config('weatherstack.api_key'));
        
        $weatherResult = $weather->run($this->locationSearch, $this->units);

        if($weatherResult === false) {
            $this->addError('locationSearch', 'Location not found');
            return;
        }

        $this->resetValidation();

        $weatherDto = (New WeatherDto())->fromJson($weatherResult);

        if($weatherDto === false) {
            $this->addError('technicalIssue', 'Technical issue, please try again later');
            return;
        }

        $this->wardrobeSuggestions = (new WardrobeSuggestionsGet($weatherDto))->run();

        $this->weather = $weatherDto->toArray();

        $this->storeRecentSearch($weatherDto->get('location.name'));
        
        $this->dispatch('weatherFetched');
    }

    public function selectRecentSearch(string $location) : void
    {
        $this->locationSearch = $location;
        $this->search();
    }

    protected function storeRecentSearch($location)
    {
        $recentSearches = session('recent_searches', []);

        $recentSearches = array_filter($recentSearches, function ($recent) use ($location) {
            return $recent !== $location;
        });

        array_unshift($recentSearches, $location);

        $recentSearches = array_slice($recentSearches, 0, 5);

        session(['recent_searches' => $recentSearches]);
    }
}
