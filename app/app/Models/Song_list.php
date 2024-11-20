<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
