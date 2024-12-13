<h1>Hello {{ $user->name }},</h1>

<p>Here is your daily report for the city : {{ $user->favorite }} :</p>

<ul>
    <div class="overflow-x-auto">
        <div class="flex space-x-4 min-w-full">
            @foreach ($weatherData as $entry)
                <div class="flex-none w-48 bg-gray-700 p-4 rounded-lg shadow-md">
                    test
                </div>
            @endforeach
        </div>
    </div>    
</ul>

<p>Bonne journée !</p>