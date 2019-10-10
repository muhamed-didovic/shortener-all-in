<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SinglePageController extends Controller
{
    public function show(Request $request)
    {
        //when we find code in db
        if ($link = \App\Link::whereCode(request()->segment(1))->first()){
            //todo: what if original_url is null
            return \Illuminate\Support\Facades\Redirect::to($link->original_url, 301);
        }

        //when code is provided but not found
        if (!empty(request()->get('any'))){
            return \Illuminate\Support\Facades\Redirect::to('/nope');
        }

        //return VUE spa app
        return view('frontend-test');

    }
}
