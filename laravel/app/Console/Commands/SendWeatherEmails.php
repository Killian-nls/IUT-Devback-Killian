<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WeatherService;
use App\Models\User;
use App\Models\WeatherQuery;
use App\Models\UserMail;
use App\Notifications\WeatherReport;

class SendWeatherEmails extends Command
{

    protected $signature = 'email:weather';
    protected $description = 'Send weather report to users with favorite cities and mail notifications';

    public function handle()
    {
        var_dump('email:weather');
        $users = User::whereNotNull('favorite')->get();

        foreach ($users as $user) {
            $weather = $this->getWeather($user->favorite);
            $cities = WeatherQuery::getCitiesByUserId($user->id);
            $savedCities = [];
            foreach ($cities as $city) {
                $weather = $this->getWeather($city);
                $savedCities[]['city'] = $weather['name'];
                $savedCities[]['temp'] = round($weather['main']['temp'] - 273.15, 2);
                $savedCities[]['feels_like'] = $weather['main']['feels_like'];
                $savedCities[]['coord'] = 'Lon: ' . $weather['coord']['lon'] . ' - Lat: ' . $weather['coord']['lat'];
            }
            
            if ($weather) {
                $user->notify(new WeatherReport($user, $weather, $savedCities));
                $this->info("Weather report notification sent to {$user->email} for {$user->favorite}");
            } else {
                $this->error("error for {$user->favorite_city}");
            }
        }

        $usersMails = UserMail::all();
        foreach ($usersMails as $userMail) {
            $weather = $this->getWeather($userMail->city_name);
            if ($weather) {
                $user = User::find($userMail->user_id);
                $user->notify(new WeatherReport($user, $weather));
                $this->info("Weather report notification sent to {$user->email} for {$userMail->city_name}");
            } else {
                $this->error("error for {$userMail->city_name}");
            }
        }
    }

    private function getWeather($city)
    {
        $service = new WeatherService;
        $weatherData = $service->getWeather($city);
        return $weatherData;
    }
}
