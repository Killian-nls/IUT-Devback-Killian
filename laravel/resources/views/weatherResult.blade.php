<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Weather Every 3 Hours') }}
        </h2>
        @if(isset($mailNotifications) && in_array($city, $mailNotifications))
            <form action="{{ route('weather.deleteMailNotification', $city) }}" method="POST" class="ml-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-envelope text-red-500 hover:text-red-500 hover:far"></i>
                    Disable mail notification
                </button>
            </form>
        @else    
            <form action="{{ route('weather.addMailNotification', $city) }}" method="POST" class="ml-2">
                @csrf
                <button type="submit" class="text-yellow-500 hover:text-yellow-700">
                    <i class="far fa-envelope text-yellow-500 hover:text-yellow-500 hover:fas"></i>
                    Enable mail notification
                </button>
            </form>
        @endif
        <form action="{{ route('weather.exportCSV', $city) }}" method="POST" class="ml-2">
            @csrf
            <button type="submit" class="text-green-500 hover:text-green-700">
                <i class="fas fa-file-csv text-green-500 hover:text-green-500 hover:far"></i>
                Export to CSV
            </button>
        </form>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold">Weather Forecast for {{ $city }} ({{ $lat }} {{ $long }})</h3>
                
                <!-- Scrollable Horizontal Container -->
                <div class="overflow-x-auto">
                    <div class="flex space-x-4 min-w-full">
                        @foreach ($data as $entry)
                            <div class="flex-none w-48 bg-gray-100 p-4 rounded-lg shadow-md">
                                <p class="text-sm"><strong>Date & Time:</strong> {{ \Carbon\Carbon::createFromTimestamp($entry['dt'])->format('Y-m-d H:i') }}</p>
                                <p class="text-lg font-semibold mt-2"><strong>Temperature:</strong> {{ number_format($entry['main']['temp'] - 273.15, 2) }} °C</p>
                                <p class="text-sm"><strong>Feels Like:</strong> {{ number_format($entry['main']['feels_like'] - 273.15, 2) }} °C</p>
                                <p class="text-sm"><strong>Weather:</strong> {{ ucfirst($entry['weather'][0]['description']) }}</p>
                                <div class="flex items-center justify-center bg-gray-700 p-2 rounded-full">
                                    <img src="http://openweathermap.org/img/wn/{{ $entry['weather'][0]['icon'] }}.png" alt="weather icon" class="w-12 h-12">
                                </div>                                <p class="text-sm mt-2"><strong>Pressure:</strong> {{ $entry['main']['pressure'] }} hPa</p>
                                <p class="text-sm"><strong>Humidity:</strong> {{ $entry['main']['humidity'] }}%</p>
                                <p class="text-sm"><strong>Wind Speed:</strong> {{ $entry['wind']['speed'] }} m/s</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
