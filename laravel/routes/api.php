<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WeatherController;
use App\Http\Controllers\Api\UserController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function() {
    Route::get('weather', [WeatherController::class, 'getWeather'])->name('getWeatherApi');
    Route::get('forecast', [WeatherController::class, 'getForecast'])->name('getForecastApi');
    Route::get('users/places', [UserController::class, 'getUserCities'])->name('getUserCitiesApi');
    Route::post('users/places', [UserController::class, 'addUserCity'])->name('addUserCityApi');
    Route::patch('users/places/{place}/send-forecast', [UserController::class, 'toggleForecast'])->name('toggleForecastApi');
    Route::patch('users/places/{place}/favorites', [UserController::class, 'toggleFavorite'])->name('toggleFavoriteApi');
    Route::patch('users/places/{place}', [UserController::class, 'deleteCity'])->name('deleteCityApi');
});