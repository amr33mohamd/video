<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
Route::prefix('room')->group(function() {
    Route::get('join/{roomName}', 'App\Http\Controllers\VideoController@joinRoom');
    Route::get('admin/join/{roomName}', 'App\Http\Controllers\VideoController@adminJoinRoom');

    Route::get('create/{roomName}', 'App\Http\Controllers\VideoController@createRoom');
});
Route::get('/rooms', "App\Http\Controllers\VideoController@index");
