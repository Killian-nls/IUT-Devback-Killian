<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\WeatherService;
use App\Http\Requests\WeatherRequest;
use App\Models\WeatherQuery;
use App\Models\User;
use App\Models\UserMail;
use Illuminate\Support\Facades\View;

class WeatherController extends Controller
{
    protected $weatherService;
    public function __construct()
    {
        $this->weatherService = new WeatherService;
    }

    public function getWeather(Request $request)
    {
        $place = $request->query('place');
        $weatherData = $this->weatherService->getWeather($place);
        return response()->json($weatherData);
    }

    public function getForecast(Request $request)
    {
        $place = $request->query('place');
        $forecastData = $this->weatherService->getNextWeekWeather($place);
        return response()->json($forecastData);
    }
}