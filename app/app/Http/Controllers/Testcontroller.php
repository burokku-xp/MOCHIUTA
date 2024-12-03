<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Testcontroller extends Controller
{
    public function test($request)
    {
        return view('test',['tests'=>$request,]);
    }

    //
}
