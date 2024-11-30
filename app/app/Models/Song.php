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

    public function songRegist($name, $artist)
    {
        $name_search = $this->where('name', $name)->first();
        $artist_search = $this->where('artist', $artist)->first();
        if ($name_search === null || $artist_search === null) {
            $this->name = $name;
            $this->artist = $artist;
            $this->save();
            return $this->id;
        } else {
            return $this->where('name', $name)->where('artist', $artist)->first()->id;
        }
    }
}
