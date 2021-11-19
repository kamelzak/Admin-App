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

Route::apiResources(['tasks' => 'App\Http\Controllers\API\TaskController']);

Route::post('tasks/{task_id}/attach', 'App\Http\Controllers\API\TaskController@assignTask');
Route::get('tasks/{task_id}/detach/{user_id}', 'App\Http\Controllers\API\TaskController@abortTask');
Route::get('tasks/{task_id}/users', 'App\Http\Controllers\API\TaskController@shwoUsersAssigned');


