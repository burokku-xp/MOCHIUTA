<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\SpotifyController;
use App\Models\List_content;
use App\Models\Song_list;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use function Laravel\Prompts\search;

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

    public function songDetail(Song_list $song_list)
    {
        $list_content = new List_content;
        $list_content = $list_content->songDetail($song_list);
        return view('song_detail', [
            'list_contents' => $list_content,
            'song_detail' => $song_list
        ]);
    }

    public function userSearchList(Song_list $song_list)
    {
        $list_content = new List_content;
        $list_content = $list_content->searchUserListDetail($song_list);
        return view('user_searchlist', [
            'list_contents' => $list_content,
            'song_detail' => $song_list
        ]);
    }

    public function songSearch(Song_list $song_list, Request $request)
    {
        $id = $song_list->id;
        $song_name = $request->song_name;
        $song_search = new SpotifyController;
        $song_search = $song_search->song_serch($song_name);

        return view('song_searchResult', [
            'song_searchs' => $song_search,
            'id' => $id
        ]);
    }

    public function artistSearch(Song_list $song_list, Request $request)
    {
        $id = $song_list->id;
        $artist_name = $request->artist_name;
        $artist_search = new SpotifyController;
        $artist_search = $artist_search->artist_serch($artist_name);

        return view('song_searchResult', [
            'song_searchs' => $artist_search,
            'id' => $id
        ]);
    }

    public function userSearchResult(Request $request)
    {
        $user_name = $request->userSearch;
        $user_search = new User;
        $user_search = $user_search->user_search($user_name);

        $song_list = new Song_list;
        $user_search = $song_list->user_listSearch($user_search);
        return view('user_searchResult', [
            'user_searchs' => $user_search
        ]);
    }
    //
}
