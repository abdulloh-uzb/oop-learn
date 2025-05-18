<?php

namespace App\Http\Controllers;

use App\Bot\WeatherApi;
use Illuminate\Http\Request;

class WeatherController extends Controller
{

    public function __construct(private WeatherApi $weatherApi)
    {}

    public function test(string $city)
    {
        return $this->weatherApi->getWeather('London');
    }
}
