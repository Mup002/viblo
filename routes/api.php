<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\UserController;
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
// Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
//     Route::post('login', [AuthController::class, 'login']);
// });

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('admin/getUsers', [UserController::class, 'getAllUser'])
        ->middleware('check.token.expiration','permission:users-all|users-view');

    Route::get('user/getArticlesByFollowers', [ArticleController::class, 'getArticleByFollower'])
        ->middleware('check.token.expiration','permission:users-all|users-view');

    Route::post('user/follows', [FollowerController::class, 'updateFollow'])
        ->middleware('check.token.expiration','permission:users-all|users-edit');

    Route::get('user/bookmarks', [ArticleController::class, 'getArticleByBookmark'])
        ->middleware('check.token.expiration','permission:users-all|users-view')->name('users.bookmarks');

    Route::post('user/updateBookmark', [BookmarkController::class, 'updateBookmark'])
        ->middleware('check.token.expiration','permission:users-all|users-edit');

    // Route::get('user/privacies', [PrivacyController::class, 'getPrivacies'])
    //     ->middleware('check.token.expiration','permission:users-all|users-view');
    Route::post('user/create/article',[ArticleController::class,'createArticleByUser'])
        ->middleware('check.token.expiration','permission:users-all|users-create');

    Route::put('user/upateArticle/{articleId}',[ArticleController::class,'updateArticle'])
        ->middleware('check.token.expiration','permission:users-all|users-edit');

    Route::post('logout',[AuthController::class,'logout']);
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers'], function () {

    //user
    // Route::get('users/getAll', ['uses' => 'UserController@getAllUser']);
    Route::post('login', ['uses' => 'AuthController@login']);
    Route::post('register', ['uses' => 'AuthController@register']);
    
    //article
    Route::get('article/getLatestArticles', ['uses' => 'ArticleController@getLatestArticle']);
    Route::get('article/getArticlesByTagId', ['uses' => 'ArticleController@getArticlesByTagId']);

    //question
    Route::get('question/getThreeLatestQuestions', ['uses' => 'QuestionController@getThreeQuestionsLatest']);

    //serie
    Route::get('series/getSeriesByPage', ['uses' => 'SerieController@getAllSerieByPage']);
    Route::get('privacies/all',['uses'=>'PrivacyController@getAll']);
    Route::post('check',['uses'=>'AuthController@checkToken']);
});
