<?php

use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1','namespace' => 'App\Http\Controllers'],function(){

    Route::get('users/getAll',['uses' => 'UserController@getAllUser']);
    // Route::post('posts/bulk',['uses' => 'PostController@bulkStore']);
    // Route::post('posts/create',['uses'=>'PostController@create']);
});
