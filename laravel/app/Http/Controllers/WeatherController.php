<?php

namespace App\Http\Controllers;

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
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
        $this->shareWeatherQueries();
        $this->shareUserMailNotifications();
    }

    //Share user's weather queries with all the views
    protected function shareWeatherQueries()
    {
        //If the user is connected
        if (auth()->check()) {
            $favoriteCity = auth()->user()->favorite;
            //Get user's weatherQueries from DB
            $weatherQueries = auth()->user()->weatherQueries()
                ->when($favoriteCity, function ($query) use ($favoriteCity) {
                    return $query->where('city', '!=', $favoriteCity);
                })
                ->get();
            //Share user's weatherQueries as $weatherQueries
            View::share('weatherQueries', $weatherQueries);
            View::share('favoriteCity', $favoriteCity);
        }
    }

    protected function shareUserMailNotifications()
    {
        //If the user is connected
        if (auth()->check()) {
            $mailNotifications = UserMail::getNotifications(auth()->id()) ?? 'test';
            View::share('mailNotifications', $mailNotifications);
        }
    }

    public function init() {
        return view('weather');
    }

    //GET weather request
    public function getWeather(WeatherRequest $request) {
        $service = new WeatherService;
        $weatherData = $service->getWeather($request->city);
        return view('weather')->with([
            'response' => 'true',
            'weather' => $weatherData['weather'][0]['main'],
            'temp' => $weatherData['main']['temp'] - 273.15 . '°C',
            'sky' => $weatherData['weather'][0]['description'],
            'icon' => $weatherData['weather'][0]['icon'],
            'pressure' => $weatherData['main']['pressure'],
            'humidity' => $weatherData['main']['humidity'],
            'windSpeed' => $weatherData['wind']['speed'],
            'clouds' => $weatherData['clouds']['all'],
            'sunrise' => date('H:i:s', $weatherData['sys']['sunrise']),
            'sunset' => date('H:i:s', $weatherData['sys']['sunset']),
            'city' => $weatherData['name'],
            'long' => $weatherData['coord']['lon'],
            'lat' => $weatherData['coord']['lat']
        ]);
        
    }
    
    //GET weather forecast request
    public function getWeatherForNextWeek(string $city, Request $request) {
        $service = new WeatherService;
        $weatherData = $service->getNextWeekWeather($city);

        WeatherQuery::firstOrCreate(
            ['user_id' => auth()->id(), 'city' => $city],
        );

        $this->shareWeatherQueries();
        
        return view('weatherResult')->with(['data' => $weatherData['list'], 'city' => $city, 'lat' => $request->lat, 'long' => $request->long]);
    }

    //DELETE user's weatherQuery
    public function deleteWeatherQuery($id){
        $query = WeatherQuery::findOrFail($id);
        UserMail::deleteNotifications($query->city);
        $query->delete();
        return redirect()->route('weather')->with('success', 'Weather query deleted successfully');
    }
    
    public function addFavorite($city){
        auth()->user()->addFavorite($city);
        $this->shareWeatherQueries();
        return redirect()->route('weather')->with('success', 'City added to favorites');
    }

    public function deleteMailNotification(Request $request) {
        $mail = UserMail::deleteNotifications($request->city);
        return redirect()->route('weather')->with('success', 'Mail notification deleted successfully');
    }

    public function addMailNotification($city) {
        $userId = auth()->id();
        $userMailEntry = new UserMail();
        $userMailEntry->addMailNotification($userId, $city);
        $this->shareUserMailNotifications();
        return redirect()->route('weather')->with('success', 'Mail notifications activated');
    }
}
