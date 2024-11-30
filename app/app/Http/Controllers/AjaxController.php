<?php

namespace App\Http\Controllers;

use App\Models\List_content;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function songDestroy(Request $request)
    {
        $songDestroy = new List_content;
        $songDestroy->songDelete($request);
    }

    public function songEdit(Request $request)
    {
        $songEdit = new List_content;
        $songEdit->songEdit($request);
    }
    //
}
