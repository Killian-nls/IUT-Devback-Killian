<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('weather', [WeatherController::class, 'init'])->name('weather');
Route::post('weatherResult', [WeatherController::class, 'getWeather'])->name('weatherResult');
Route::get('/weatherNextWeek/{city}', [WeatherController::class, 'getWeatherForNextWeek'])->name('weatherCityWeek');
Route::delete('/weather/{id}', [WeatherController::class, 'deleteWeatherQuery'])->name('weather.delete');
Route::post('/weather/favorite/{id}', [WeatherController::class, 'addFavorite'])->name('weather.addFavorite');
Route::delete('/weather/notification/{city}', [WeatherController::class, 'deleteMailNotification'])->name('weather.deleteMailNotification');
Route::post('/weather/mailNotification/{city}', [WeatherController::class, 'addMailNotification'])->name('weather.addMailNotification');
require __DIR__.'/auth.php';

//TODO - 
/**
 * On a maintenant la table user_mails qui permet de savoir a qui envoyer quels mails
 * Mais c'est pas coddé
 */