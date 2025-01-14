<?php

use App\Services\WeatherService;

it('test communication with openweather API', function () {
    $weatherService = new WeatherService();
    $response = $weatherService->getWeather("London");
    $this->assertEquals(200, $response['cod']);  
});

it('test get weather for a city', function () {
    $weatherService = new WeatherService();
    $response = $weatherService->getWeather("London");
    $this->assertEquals("London", $response['name']);  
    $this->assertArrayHasKey("main", $response);
    $this->assertArrayHasKey("weather", $response); 
});

it('test get weather forecast for a city', function () {
    $weatherService = new WeatherService();
    $response = $weatherService->getNextWeekWeather("London");
    $this->assertEquals("London", $response['city']['name']);  
    $this->assertArrayHasKey("list", $response);
    $this->assertArrayHasKey("cnt", $response);
});
