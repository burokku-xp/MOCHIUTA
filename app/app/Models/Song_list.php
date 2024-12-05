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

    public function user_listSearch($datas)
    {
        foreach ($datas as $data) {
            $lists = $this->where("is_private", "0")->where("user_id", $data["user_id"])->get();
            foreach ($lists as $list) {
                $datas[$data["user_id"]]["list_content"][$list->id]["list_id"] = $list->id;
                $datas[$data["user_id"]]["list_content"][$list->id]["list_name"] = $list->name;
            }
        }
        return $datas;
    }
}
