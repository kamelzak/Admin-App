<?php

use Illuminate\Support\Facades\Route;

Route::get('/auth/redirect', 'App\Http\Controllers\Auth\LoginController@redirectToProvider');

Route::get('/auth/callback', 'App\Http\Controllers\Auth\LoginController@handleProviderCallBack');

Route::get('/', function () {
    return redirect('/dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/{path}', 'App\Http\Controllers\HomeController@index')->where('path', '.*');
