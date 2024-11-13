<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function title ()
    {
        return view('title');
    }
    public function mypage()
    {
        return view('mypage');
    }
    //
}
