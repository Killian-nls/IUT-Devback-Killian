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

class UserController extends Controller
{
    public function getUserCities(Request $request) {
        $user = $request->user();
        $weatherQueries = $user->weatherQueries()->pluck('city');
        $cities = $weatherQueries->merge($user->favorite)->unique();
        return response()->json(["places" => $cities]);
    }

    public function addUserCity(Request $request) {
        $request->validate([
            'place' => 'required|string'
        ]);
        $user = $request->user();
        $user->weatherQueries()->create(['city' => $request->place]);
        return response()->json(["message" => "City added successfully"]);
    }

    public function toggleForecast(string $place, Request $request) {
        $user = $request->user();
        $userId = $user->id;
        $notification = UserMail::getNotifications($userId);
        foreach ($notification as $n) {
            if ($n === $place) {
                UserMail::deleteNotifications($place);
                return response()->json(["message" => "Notification removed for $place successfully"]);
            }
        }
        $userMailEntry = new UserMail();
        $userMailEntry->addMailNotification($userId, $place);
        return response()->json(["message" => "Notification added for $place successfully"]);
    }

    public function toggleFavorite(string $place, Request $request) {
        $user = $request->user();
        $favorite = $user->favorite;
        if ($favorite == $place) {
            $user->favorite = null;
            $user->save();
            return response()->json(["message" => "Favorite city $place removed successfully"]);
        }
        $user->favorite = $place;
        $user->save();
        return response()->json(["message" => "Favorite city $place added successfully"]);
    }

    public function deleteCity(string $place, Request $request) {
        $user = $request->user();
        if ($user->favorite == $place) {
            $user->favorite = null;
            $user->save();
        }
        $user->weatherQueries()->where('city', $place)->delete();
        UserMail::deleteNotifications($place);
        return response()->json(["message" => "City $place deleted successfully"]);
    }
}