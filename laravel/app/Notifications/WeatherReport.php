<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Mail\Message;

class WeatherReport extends Notification
{
    public $user;
    public $weatherData;
    public $savedCities;

    public function __construct($user, $weatherData, $savedCities = null)
    {
        $this->user = $user;
        $this->weatherData = $weatherData;
        $this->savedCities = $savedCities;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
                    ->line('Your daily weather report for ' . $this->weatherData['name'])
                    ->line('Coordinates: ' . 'Lon: ' . $this->weatherData['coord']['lon'] . ', Lat: ' . $this->weatherData['coord']['lat'])
                    ->line('Weather: ' . $this->weatherData['weather'][0]['main'] . ' (' . $this->weatherData['weather'][0]['description'] . ')')
                    ->line('Temperature: ' . number_format($this->weatherData['main']['temp'] - 273.15, 2) . '°C')
                    ->line('Feels Like: ' . number_format($this->weatherData['main']['feels_like'] - 273.15, 2) . '°C')
                    ->line('Min Temperature: ' . number_format($this->weatherData['main']['temp_min'] - 273.15, 2) . '°C')
                    ->line('Max Temperature: ' . number_format($this->weatherData['main']['temp_max'] - 273.15, 2) . '°C')
                    ->line('Pressure: ' . $this->weatherData['main']['pressure'] . ' hPa')
                    ->line('Humidity: ' . $this->weatherData['main']['humidity'] . '%')
                    ->line('Visibility: ' . $this->weatherData['visibility'] . ' meters')
                    ->line('Wind Speed: ' . $this->weatherData['wind']['speed'] . ' m/s')
                    ->line('Wind Direction: ' . $this->weatherData['wind']['deg'] . '°')
                    ->line('Cloudiness: ' . $this->weatherData['clouds']['all'] . '%')
                    ->line('Sunrise: ' . date('H:i:s', $this->weatherData['sys']['sunrise']))
                    ->line('Sunset: ' . date('H:i:s', $this->weatherData['sys']['sunset']))
                    ->line('Timezone: ' . $this->weatherData['timezone'] . ' seconds from UTC')
                    ->line('Report generated at: ' . date('Y-m-d H:i:s', $this->weatherData['dt']));
    
        $csvData = "City,Temperature,Feels Like,Coordinates";
        if ($this->savedCities !== null) {

            foreach ($this->savedCities as $city) {
                foreach ($city as $key => $value) {
                    if ($key === 'city') {
                        $csvData .= "\n" . $value . ',';
                    } else {
                        $csvData .= $value . ",";
                    }
                }
            }
            $filePath = 'weather_reports/saved_cities.csv';
            Storage::put($filePath, $csvData);
        
            $mailMessage->attach(Storage::path($filePath), [
                'as' => 'saved_cities.csv',
                'mime' => 'text/csv',
            ]);
        }
    
    
        return $mailMessage;
    }
}