<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Inertia('Home');
});

Route::group(['prefix'=> 'pokemon'], function () {
    Route::get('dashboard', function(){
        return Inertia('Dashboard');
    })->name('dashboard');

    Route::get('users', function(){
        return Inertia('Users');
    })->name('users');
});