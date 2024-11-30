<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class List_content extends Model
{
    use HasFactory;
    protected $fillable = ['points', 'comment', 'music_data'];

    public function song()
    {
        return $this->belongsTo('App\Models\Song');
    }

    public function song_list()
    {
        return $this->belongsTo('App\Models\Song_list');
    }

    public function contentRegist($request, $path, $id)
    {
        $this->points = $request->points;
        $this->comment = $request->comment;
        $this->music_data_path = $path;
        $this->song_id = $id['song_id'];
        $this->list_id = $id['list_id'];
        return $this->save();
    }

    public function songDetail($song_list)
    {
        return $this::join('songs', 'list_contents.song_id', '=', 'songs.id')
            ->where('list_id', $song_list->id)
            ->select('list_contents.id', 'points', 'comment', 'music_data_path', 'songs.id as song_id', 'songs.name', 'songs.artist')
            ->get();
    }

    public function songDelete($song_id)
    {
        return $this::find($song_id->id)->delete();
    }

    public function songEdit($song_id)
    {
        return ;/*$this::find($song_id->id)->*/
    }
}
