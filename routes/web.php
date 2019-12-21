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

Route::get('/', function(){
    return view('welcome');
});

Route::get('drafts', 'DraftsController@index');
Route::get('/drafts/create', 'DraftsController@create');
Route::post('drafts', 'DraftsController@store');

Route::get('/drafts/{draft}/edit', 'DraftsController@edit');
Route::patch('/drafts/{draft}', 'DraftsController@update');
Route::delete('/drafts/{draft}/delete', 'DraftsController@destroy');

