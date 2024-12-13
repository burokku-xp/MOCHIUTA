<?php

namespace App\Http\Controllers;

use App\Models\Favorite_user;
use App\Models\List_content;
use App\Models\User;
use App\Models\Song_list;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\ErrorHandler\Debug;

class AjaxController extends Controller
{
    public function songDestroy(Request $request)
    {
        $songDestroy = new List_content;
        $songDestroy->songDelete($request);
    }

    public function songEdit(Request $request)
    {
        if (!($request->file('mp3_data') === null)) {
            //音声ファイル名をハッシュ化してパスを取得し保存
            $path = $request->file('mp3_data')->storeAs('', $request->file('mp3_data')->hashName());
        } else {
            $path = null;
        }
        $songEdit = new List_content;
        $songEdit->songEdit($request, $path);

        return response()->json([
            'updatedContent' => $path
        ]);
    }

    public function favoriteUser(Request $request)
    {
        $Favorite_user = new Favorite_user;
        $Favorite_user = $Favorite_user->Regist($request["id"]);
        return;
    }

    public function favoriteUserDelete(Request $request)
    {
        $Favorite_user = new Favorite_user;
        $Favorite_user = $Favorite_user->Delete_id($request["id"]);
        return;
    }

    public function userSearchResult(Request $request)
    {
        $user_name = $request->val;
        $user_search = new User;
        $user_search = $user_search->user_search($user_name);

        if (empty($user_search)) {
            $user_search = [];
            $favorite_user = [];
        } else {
            $song_list = new Song_list;
            $user_search = $song_list->user_listSearch($user_search);

            $favorite_user_data = Auth::user()->favorite_user()->get()->toArray();

            if (!(empty($favorite_user_data))) {
                $favorite_user = new User();
                $favorite_user = $favorite_user->mypage($favorite_user_data);

                $song_list = new Song_list;
                $favorite_user = $song_list->user_listSearch($favorite_user);
            } else {
                $favorite_user = [];
            }
        }
        return response()->json([
            'user_searchs' => $user_search,
            'favorite_users' => $favorite_user
        ]);
    }
    //
}
