<?php

namespace App\Http\Controllers;

use App\Models\Favorite_user;
use App\Models\List_content;
use Illuminate\Http\Request;
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
    //
}
