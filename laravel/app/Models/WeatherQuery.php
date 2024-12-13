<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherQuery extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'city', 'weather_data'];

    protected $casts = [
        'weather_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getCitiesByUserId($userId)
    {
        return self::where('user_id', $userId)->pluck('city')->toArray();
    }
}