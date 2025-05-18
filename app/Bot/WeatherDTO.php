<?php

namespace App\Bot;

class WeatherDTO
{

    public function __construct(public string $city, public int $temperature)
    {
    }

    public static function fromArray(array $data)
    {
        return new self(
            city: $data['location']['name'],
            temperature: $data['current']['temp_c']
        );
    }

    public function toArray(): array
    {
        return [
            'city' => $this->city,
            'temperature' => $this->temperature,
        ];
    }
}
