<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/weather', [WeatherController::class, 'test']);