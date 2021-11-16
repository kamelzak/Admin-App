<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['users' => 'App\Http\Controllers\API\UserController']);

Route::get('profile', 'App\Http\Controllers\API\UserController@profile');
Route::put('profile', 'App\Http\Controllers\API\UserController@updateProfile');

Route::get('user', 'App\Http\Controllers\API\UserController@getUser');
