<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WeatherService;

class getWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:weather {city}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $city = $this->argument('city');
        $weatherService = new WeatherService();
        $weather = $weatherService->getWeather($city);
        $info = $weather['name'] . ': ' . $weather['main']['temp'] - 273 . '°C' . PHP_EOL
            . 'Feels like: ' . $weather['main']['feels_like'] - 273 . '°C' . PHP_EOL
            . 'Weather: ' . $weather['weather'][0]['description'] . PHP_EOL
            . 'Lon: ' . $weather['coord']['lon'] . ' - Lat: ' . $weather['coord']['lat'];  
        $this->info($info);
    }
}
