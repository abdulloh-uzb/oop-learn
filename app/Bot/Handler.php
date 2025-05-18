<?php

namespace App\Bot;

class Handler
{

    public function __construct(private WeatherApi $weatherApi)
    {
    }

    public function handle(string $text)
    {
        $text = strtolower(trim($text));
        $parts = explode(' ', $text, 2);
        $command = $parts[0];
        $argument = $parts[1] ?? '';
        
        switch ($command) {
            case '/start':
                return "👋 Welcome to the bot!";
                break;
            
            case '/help':
                return "Available commands:\n/start\n/weather {city}";

            case '/weather':
                return $this->weather($argument); 
            
            default:
                return "❓ Unknown command. Type /help.";
        }
    }

    private function weather(string $city)
    {
        $data = $this->weatherApi->getWeather($city);
        $text = "{$data->city} da ob havo {$data->temperature} gradus";
        return $text;
    }

}