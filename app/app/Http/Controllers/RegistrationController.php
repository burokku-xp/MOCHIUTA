<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListData;
use App\Models\List_content;
use App\Models\Song;
use App\Models\Song_list;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    //
    public function listRegist(ListData $request)
    {
        $songList = new Song_list;
        $songList = $songList->list_regist($request);

        // CSRFトークンの再発行
        $request->session()->regenerateToken();
        return redirect('/mypage');
    }

    public function listDelete(Song_list $song_list)
    {
        $songList = new Song_list;
        $songList = $songList->list_delete($song_list);

        return redirect()->route('mypage');
    }

    public function listContentRegist(Song_list $song_list, ListData $request)
    {
        // 登録する曲がsongsテーブルに登録されているかのチェック→登録なければ登録してIDを拾う／あればそのままIDを拾う
        $songRegist = new Song();
        $songRegist['song_id'] = $songRegist->songRegist($request->name, $request->artist, $request->jacket);
        $songRegist['list_id'] = $song_list->id;
        if (!($request->file('mp3_data') === null)) {
            //音声ファイル名をハッシュ化してパスを取得し保存
            $path = $request->file('mp3_data')->storeAs('', $request->file('mp3_data')->hashName());
        } else {
            $path = null;
        }
        //listcontentsテーブルへの登録
        $list_contents = new List_content;
        $list_contents->contentRegist($request, $path, $songRegist);

        // CSRFトークンの再発行
        $request->session()->regenerateToken();

        return redirect()->route('song.detail', $song_list);
    }
}
