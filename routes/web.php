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
Auth::routes();


// DRAFT CRUD
Route::get('drafts', 'DraftsController@index');
Route::get('/drafts/create', 'DraftsController@create'); // form insert
//Route::post('drafts', 'DraftsController@store'); // action insert
Route::get('/drafts/{draft}/edit', 'DraftsController@edit'); //form edit
Route::patch('/drafts/{draft}', 'DraftsController@update'); //action edit
Route::delete('/drafts/{draft}/delete', 'DraftsController@destroy'); // action delete
Route::post('/drafts/{draft}/publish', 'DraftsController@publish');



Route::get('/', 'ArticlesController@index');
Route::get('/articles/{article}', 'ArticlesController@show');
Route::patch('/articles/{article}/like', 'ArticlesController@like')->middleware('auth');
Route::patch('/articles/{article}/dislike', 'ArticlesController@dislike')->middleware('auth');
Route::delete('/articles/{article}/delete', 'ArticlesController@destroy')->middleware('auth');
Route::post('/articles/{article}/report', 'ArticlesController@report')->middleware('auth');
