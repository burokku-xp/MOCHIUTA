<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Favorite_user extends Model
{
    use HasFactory;

    public function Regist($id)
    {
        $this->user_id = Auth::id();
        $this->favoriteuser_id = $id;
        return $this->save();
    }

    public function Delete_id($id)
    {
        $this->where("user_id",Auth::id())->where("favoriteuser_id",$id)->delete();
        return;
    }

}
