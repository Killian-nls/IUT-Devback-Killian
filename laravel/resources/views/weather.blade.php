<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Weather') }}
        </h2>
    </x-slot>

    <form action="{{ route('weatherResult') }}" method="POST">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @csrf
                    <div class="mb-4">
                        <label class="text-lg font-semibold" for="city">City:</label>    
                        <input name='city' type="text" class="form-input mt-1 block w-full">
                    </div>    
                    <div>
                        <button class="weather-btn" type="submit">Search</button>
                    </div>
                </div>
            </div>
        </div>    
    </form>
    
    @if (isset($response) && $response == 'true')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-4">Current Weather for {{ $city }} ({{ $long }} / {{ $lat }})</h3>
                
                <div class="flex overflow-x-auto space-x-4">
                    <div class="weather-card">
                        <h4 class="weather-header">Temperature</h4>
                        <p><strong>Temperature:</strong> {{ ucfirst($temp) }}</p>
                    </div>

                    <div class="weather-card">
                        <h4 class="weather-header">Weather</h4>
                        <p><strong>Weather:</strong> {{ ucfirst($weather) }}</p>
                        <p><strong>Sky:</strong> {{ ucfirst($sky) }}</p>
                        <div class="flex items-center justify-center bg-red-700 p-2 rounded-full">
                                    <img src="http://openweathermap.org/img/wn/{{ $icon }}.png" alt="weather icon" class="w-12 h-12">
                        </div>
                    </div>
                    
                    <div class="weather-card">
                        <h4 class="weather-header">Conditions</h4>
                        <p><strong>Pressure:</strong> {{ $pressure }} hPa</p>
                        <p><strong>Humidity:</strong> {{ $humidity }}%</p>
                        <p><strong>Wind Speed:</strong> {{ $windSpeed }} m/s</p>
                        <p><strong>Cloud Coverage:</strong> {{ $clouds }}%</p>
                    </div>
                    
                    <div class="weather-card">
                        <h4 class="weather-header">Sun Details</h4>
                        <p><strong>Sunrise:</strong> {{ $sunrise }}</p>
                        <p><strong>Sunset:</strong> {{ $sunset }}</p>
                    </div>

                    <div class="weather-card">
                        <h4 class="weather-header">Coordinates</h4>
                        <p><strong>Latitude:</strong> {{ $lat }}</p>
                        <p><strong>Longitude:</strong> {{ $long }}</p>
                    </div>
                    
                    <div class="weather-card">
                        <a href="{{ route('weatherCityWeek', ['city' => $city, 'lat' => $lat, 'long' => $long]) }}" class="text-blue-500 hover:underline">
                            See next week's weather for {{ $city }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(isset($data))
    <p>{{$data}}</p>
    @endif

    @if(isset($test))
    <p>{{$test}}</p>
    @endif
</x-app-layout>
