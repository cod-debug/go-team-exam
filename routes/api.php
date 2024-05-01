<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group([
	'prefix' => 'auth',
	'as' => 'api.auth.',
	'namespace' => 'App\Http\Controllers',
],function () {
    Route::post('/register', 'AuthController@register')->name('register');
    Route::post('/login', 'AuthController@loginUser')->name('login');
});

Route::group([
	'prefix' => 'users',
	'as' => 'api.users.',
	'namespace' => 'App\Http\Controllers',
],function () {
    Route::post('/like-pokemon', 'UserController@addLikedPokemon')->name('like-pokemon');
    Route::post('/dislike-pokemon', 'UserController@addDislikedPokemon')->name('dislike-pokemon');
    Route::get('/list', 'UserController@list')->name('user-list');
});