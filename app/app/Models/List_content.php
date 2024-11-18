<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class List_content extends Model
{
    use HasFactory;
    protected $fillable = ['points', 'comment','music_data'];

    public function song()
    {
        return $this->belongsTo('App\Models\Song','song_id','id');
    }

    public function song_list()
    {
        return $this->belongsTo('App\Models\Song_list','list_id','id');
    }
}
