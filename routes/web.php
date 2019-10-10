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

Route::post('short', 'LinkController@store');
Route::get('short', 'LinkController@show');
Route::get('stats', 'LinkStatsController@show');

//Auth::routes();
//Route::get('/home/', 'HomeController@index')->name('home');

//ROUTE for vue
Route::get('/{any?}', 'SinglePageController@show')->where('any', '.*');
