<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
////    dd(database_path('database.sqlite'));
//    return view('welcome');
//});


Route::get('redirect/{code}', static function ($code) {

    if ($link = \App\Link::whereCode($code)->first()){
        //todo: what if original_url is null
        return \Illuminate\Support\Facades\Redirect::to($link->original_url, 301);
    }
    return \Illuminate\Support\Facades\Redirect::to('/nope');
});
Route::post('short', 'LinkController@store');
Route::get('short', 'LinkController@show');
Route::get('stats', 'LinkStatsController@show');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::get('/{any}', 'SinglePageController@index')->where('any', '.*');
//ROUTE for vue
Route::get(
    '{path}',
    function () {
        return view('frontend-test');
    }
)->where('path', '.*');
