# Project IUT WeatherApp Laravel
by Killian Mathé

## Registration
To register, navigate to the `/register` route.

## Features
- **Search Weather**: Search for a city's weather to get a weekly forecast.
- **Save Cities**: Click "See city's weather forecast" to add a city to your saved cities.
- **Favorite City**: Click the star to add a city to your favorites, which will override the previous favorite city.
- **Mail Notifications**: Enable mail notifications for a city to receive daily weather emails for that city.

## Terminal Commands
- `php artisan email:weather`: Send an email to all users with their emailable and favorite cities' weather.
- `php artisan get:weather {city}`: Return the current weather for the specified city.

## API Endpoints
- `GET /api/v1/weather?place={city}`: Return the current weather for the specified city.
- `GET /api/v1/forecast?place={city}`: Return the city's weekly forecast (updated every 3 hours).
- `GET /api/v1/users/places`: Return the current user's saved cities.
- `POST /api/v1/users/places` (Body: `{"place": "{city}"}`): Add a city to the user's saved cities.
- `PATCH /api/v1/users/places/{city}/send-forecast`: Toggle mail notifications for the specified city.
- `PATCH /api/v1/users/places/{city}/favorites`: Toggle favorite status for the specified city (overrides previous favorite city).
- `PATCH /api/v1/users/places/Bordeaux`: Delete the city from the user's saved cities.

## Useful Commands
### First Time Setup
**Note**: `docker compose up` does not work as the user will not have write access to the `/var/www/app/laravel` folder and won't be able to install dependencies.

- `composer install`: Install back-end dependencies.
- `npm install`: Install front-end dependencies.
- `npm run build`: Build the front-end.

### Running the Project
- `php artisan serve`
- `php artisan migrate`