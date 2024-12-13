<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Services\WeatherService;
use App\Models\User;
use App\Models\WeatherQuery;
use App\Notifications\WeatherReport;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('email:weatherNotification', function () {
    Artisan::call('email:weather');
})->purpose('Send weather report to users with favorite cities')->everyMinute();
