<?php

use App\DTO\WeatherDto;
use PHPUnit\Framework\TestCase;
use App\Actions\WardrobeSuggestionsGet;

class WardrobeSuggestionsGetTest extends TestCase
{
    public function testSuggestionCanBeCreated()
    {
        $weatherDto = new WeatherDto();
        $wardrobeSuggestionsGet = new WardrobeSuggestionsGet($weatherDto);
        $this->assertInstanceOf(WardrobeSuggestionsGet::class, $wardrobeSuggestionsGet);
    }
}
