<?php

/*
    This class's responsibility is to get weather data from external api based on city name.
    This class inject weatherDTO and returns weatherDTO object.
*/

namespace App\Bot;

use App\Bot\WeatherDTO;
use Illuminate\Http\Client\Factory as HttpClient;

class WeatherApi
{
    protected HttpClient $httpClient;
    protected string $apiKey;

    // inject http client
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = env('WEATHER_API_TOKEN');
    }

    public function getWeather(string $city): WeatherDTO
    {

        // get data from external api
        $data = $this->httpClient->withoutVerifying()->get("http://api.weatherapi.com/v1/current.json", [
            "key" => $this->apiKey,
            "q" => $city,
        ]);

        return new WeatherDTO(
            city: $data['location']['name'],
            temperature: $data['current']['temp_c']
        );   
    }
}
