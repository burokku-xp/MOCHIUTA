<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListData;
use App\Models\Song_list;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    //
    public function listRegist(ListData $request)
    {
        $songList = new Song_list;

        $songList->name = $request->name;
        if ($request->is_private == '公開') {
            $songList->is_private = '0';
        } else {
            $songList->is_private = '1';
        }

        Auth::user()->song_list()->save($songList);

        $request->session()->regenerateToken();
        return redirect('/mypage');
    }
}
