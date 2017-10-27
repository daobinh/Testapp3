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

Route::get('/', function () {
    return view('list');
});
Route::resource('member', 'MemberController');

Route::get('members/{id?}', 'MemberController@getlist');


Route::post('member/{id?}', 'MemberController@update');


Route::get('delete/{id?}', 'MemberController@destroy');