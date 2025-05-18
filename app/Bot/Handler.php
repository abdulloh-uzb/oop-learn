<?php

namespace App\Bot;

class Handler
{

    public function __construct(private WeatherApi $weatherApi)
    {
    }

    public function handle(string $city)
    {
        $data = $this->weatherApi->getWeather($city);
        $text = "{$data->city} da ob havo {$data->temperature} gradus";
        return $text;
    }

}