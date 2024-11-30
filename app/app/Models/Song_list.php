<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Song_list extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'is_private'];

    public function list_content()
    {
        return $this->hasMany('App\Models\List_content', 'id', 'list_id');
    }

    public function favorite_user()
    {
        return $this->hasMany('App\Models\Favorite_user', 'favoriteuser_id', 'user_id');
    }

    public function list_regist($request)
    {
        $this->name = $request->name;
        if ($request->is_private == '公開') {
            $this->is_private = '0';
        } else {
            $this->is_private = '1';
        }

        Auth::user()->song_list()->save($this);
    }
}
