<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;


class UserMail extends Model
{

    protected $table = 'user_mails';

    protected $fillable = [
        'user_id',
        'city_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getNotifications($userId)
    {
        return self::where('user_id', $userId)->pluck('city_name')->toArray();
    }

    public static function deleteNotifications($city)
    {
        return self::where('city_name', $city)->delete();
    }

    public function addMailNotification(int $userId, string $city)
    {
        $this->user_id = $userId;
        $this->city_name = $city;
        return $this->save();
    }
}