<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\SpotifyController;
use App\Models\List_content;
use App\Models\Song_list;
use App\Models\Favorite_user;
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
        //ログインユーザーのリスト
        $songListAll = Auth::user()->song_list()->get();

        //お気に入りユーザーと公開リスト
        $favorite_user_data = Auth::user()->favorite_user()->get()->toArray();
        if (!(empty($favorite_user_data))) {
            $favorite_user = new User();
            $favorite_user = $favorite_user->mypage($favorite_user_data);

            $song_list = new Song_list;
            $favorite_user = $song_list->user_listSearch($favorite_user);

            foreach ($favorite_user as $list) {
                if (empty($list["list_content"])) {
                    $favorite_user[$list["user_id"]]["list_content"] = [];
                }
            }
        } else {
            $favorite_user = [];
        }

        return view('mypage', [
            'song_list' => $songListAll,
            'favorite_users' => $favorite_user
        ]);
    }

    public function fetchFavoriteUsers()
    {
        $favorite_user_data = Auth::user()->favorite_user()->get()->toArray();
        if (!(empty($favorite_user_data))) {
            $favorite_users = new User();
            $favorite_users = $favorite_users->mypage($favorite_user_data);

            $song_list = new Song_list;
            $favorite_users = $song_list->user_listSearch($favorite_users);

            foreach ($favorite_users as $list) {
                if (empty($list["list_content"])) {
                    $favorite_users[$list["user_id"]]["list_content"] = [];
                }
            }
        } else {
            $favorite_users = [];
        }
        return view('partials.favorite_users', compact('favorite_users'))->render();
    }

    public function songDetail(Song_list $song_list)
    {
        $list_content = new List_content;
        $list_content = $list_content->songDetail($song_list);
        $private = $song_list->is_private;
        if ($private === 0) {
            return view('song_detail', [
                'list_contents' => $list_content,
                'song_detail' => $song_list
            ]);
        } else {
            if (Auth::id() === $song_list->user_id) {
                return view('song_detail', [
                    'list_contents' => $list_content,
                    'song_detail' => $song_list
                ]);
            }
            return redirect()->route('mypage');
        }
    }

    public function userSearchList(Song_list $song_list)
    {
        $list_content = new List_content;
        $list_content = $list_content->searchUserListDetail($song_list);

        $private = $song_list->is_private;
        if ($private === 0) {
            return view('user_searchlist', [
                'list_contents' => $list_content,
                'song_detail' => $song_list
            ]);
        } else {
            if (Auth::id() === $song_list->user_id) {
                return view('user_searchlist', [
                    'list_contents' => $list_content,
                    'song_detail' => $song_list
                ]);
            }
            return redirect()->route('mypage');
        }
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
    //
}
