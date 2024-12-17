<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Mail\ResetPassMail;
use App\Notifications\PasswordResetNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token, new ResetPassMail()));
    }

    public function song_list()
    {
        return $this->hasMany('App\Models\Song_list');
    }

    public function favorite_user()
    {
        return $this->hasMany('App\Models\Favorite_user');
    }

    public function user_search($user_name)
    {
        //ユーザー名部分一致検索
        $user_search = $this->where([
            ["role", "1"],
            ["name", "LIKE", "%" . $user_name . "%"],
            ["id", "!=", Auth::id()]
        ]);
        $names = $user_search->take(5)->get();

        if ($names->isEmpty()) {
            return null;
        } else {
            $favorite_user = Auth::user()->Favorite_user()->get();
            foreach ($names as $name) {
                $data[$name->id]["user_id"] = $name->id;
                $data[$name->id]["user_name"] = $name->name;
                $data[$name->id]["favorite"] = "false";
                $data[$name->id]["list_content"] = [];
                foreach ($favorite_user as $favorite) {
                    if ($name->id === $favorite->favoriteuser_id) {
                        $data[$name->id]["favorite"] = "true";
                        break;
                    } else {
                        $data[$name->id]["favorite"] = "false";
                    }
                }
            }
            return $data;
        }
    }

    public function mypage($favorite_user_data)
    {
        $favorite_user = Auth::user()->Favorite_user()->get();
        foreach ($favorite_user_data as $data) {
            $gets = $this->where("id", $data["favoriteuser_id"])->get();
            foreach ($gets as $get) {
                $result[$get->id]["user_id"] = $get->id;
                $result[$get->id]["user_name"] = $get->name;
                $result[$get->id]["favorite"] = "false";
                foreach ($favorite_user as $favorite) {
                    if ($get->id === $favorite->favoriteuser_id) {
                        $result[$get->id]["favorite"] = "true";
                        break;
                    } else {
                        $result[$get->id]["favorite"] = "false";
                    }
                }
            }
        }
        return $result;
    }
}
