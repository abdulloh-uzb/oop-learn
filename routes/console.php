<?php

use App\Telegram\WeatherApi;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Artisan::command('bot:run', function () {
//     $bot = new \App\Telegram\Bot(
//         app(\Illuminate\Http\Client\Factory::class),
//         app(\App\Telegram\WeatherApi::class)
//     );
//     $bot->getUpdates();
// });