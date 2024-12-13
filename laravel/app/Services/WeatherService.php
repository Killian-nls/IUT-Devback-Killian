<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $baseUrl;

    public function __construct() {
        $this->baseUrl = config("services.weather.url");
    }

    public function getWeather($city) {
        $response = Http::get("$this->baseUrl/weather?q=$city&appid=" . config("services.weather.key"));
        return $response->json();
    }

    public function getNextWeekWeather($city) {
        $response = Http::get("$this->baseUrl/forecast?q=$city&appid=" . config("services.weather.key"));
        return $response->json();
    }
}
