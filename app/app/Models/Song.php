<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'artist'];

    public function list_contents()
    {
        return $this->hasMany('App\Models\List_content');
    }

    public function songRegist($name, $artist, $path)
    {
        $name_search = $this->where('name', $name)->first();
        $artist_search = $this->where('artist', $artist)->first();
        if ($name_search === null || $artist_search === null) {
            $this->name = $name;
            $this->artist = $artist;
            $this->path = $path;
            $this->save();
            return $this->id;
        } else {
            return $this->where('name', $name)->where('artist', $artist)->first()->id;
        }
    }

    public function suggest_song($list_contents)
    {
        //ユーザーの登録している全楽曲から重複無しでランダムに5曲選出
        $list_contents = collect($list_contents)->flatten()->unique();
        $list_contents = $list_contents->random(min(5, count($list_contents)))->toArray();
        foreach ($list_contents as $list_content) $suggest_song_paths[] = $this->where("id", $list_content)->select("path")->get()->flatten()->toArray();
        foreach ($suggest_song_paths as $suggest_song_path) $path[] = $suggest_song_path[0]["path"];
        $path = collect($path)->map(fn($item) => "'{$item}'")->implode(',');
        return $path;
    }
}
