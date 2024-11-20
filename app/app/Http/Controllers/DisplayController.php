<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\SpotifyController;
use App\Models\Song_list;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function title()
    {
        return view('title');
    }

    public function mypage()
    {
        $songListAll = Auth::user()->song_list()->get();
        return view('mypage', [
            'song_list' => $songListAll
        ]);
    }
    //
}
