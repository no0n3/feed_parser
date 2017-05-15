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

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/x', 'XxController@index');
Route::get('/feed/get-all', 'FeedController@getAll');
Route::get('/feed-source/get-all', 'FeedSourceController@getAll');
Route::post('/feed-source/add', 'FeedSourceController@create');
