<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
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

// 'check.cookie',
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    //admin
    Route::get('admin-management/users', [UserController::class, 'getAllUser'])
        ->middleware('check.token.expiration', 'permission:users-all|users-view');

    //user-article
    Route::get('articles-management/users/followers', [ArticleController::class, 'getArticleByFollower'])
        ->middleware('check.token.expiration', 'permission:users-all|users-view');

    Route::get('articles-management/users/bookmarks', [ArticleController::class, 'getArticleByBookmark'])
        ->middleware('check.token.expiration', 'permission:users-all|users-view')->name('users.bookmarks');

    Route::post('users/articles', [ArticleController::class, 'createArticleByUser'])
        ->middleware('check.token.expiration', 'permission:users-all|users-create');

    Route::put('users/articles/{articleId}', [ArticleController::class, 'updateArticle'])
        ->middleware('check.token.expiration', 'permission:users-all|users-edit');

    Route::get('users/articles/{address_url}', [ArticleController::class, 'getArticleAuth'])
        ->middleware('check.token.expiration','permission:users-edit');
    //user-other
    Route::put('comments', [CommentController::class, 'editCmt'])
        ->middleware('check.token.expiration', 'permission:users-all|users-edit');
    Route::post('users/follows', [FollowerController::class, 'updateFollow'])
        ->middleware('check.token.expiration', 'permission:users-all|users-edit');
    Route::post('comments', [CommentController::class, 'createCmt'])
        ->middleware('check.token.expiration', 'permission:users-all|users-create');
    Route::post('users/bookmarks', [BookmarkController::class, 'updateBookmark'])
        ->middleware('check.token.expiration', 'permission:users-all|users-edit');
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers'], function () {
    //user
    Route::get('/profile/{id}',['uses'=>'UserController@getProfile']);
    //auth
    Route::post('login', ['uses' => 'AuthController@login'])->name('login');
    Route::post('register', ['uses' => 'AuthController@register']);
    // articles-management/users/followers
    //article
    Route::get('articles', ['uses' => 'ArticleController@getLatestArticle']);
    Route::get('articles/tags', ['uses' => 'ArticleController@getArticlesByTagId']);
    Route::get('articles/{address_url}', ['uses' => 'ArticleController@getArticle']);
    Route::get('articles/author-relate/{url}',['uses'=>'ArticleController@getaArticleRelateByAuthor']);
    Route::get('articles/tags/{id}',['uses'=>'ArticleController@getArticleByTag']);
    Route::get('articles/relate/{url}', ['uses'=>'ArticleController@getArticleRelate']);
    Route::get('articles/author/{id}',['uses'=>'ArticleController@getArticlesByAuthor']);

    //question
    Route::get('questions/threeLatest', ['uses' => 'QuestionController@getThreeQuestionsLatest']);
    Route::get('questions/author/{id}',['uses'=>'QuestionController@getQuestionByAuthor']);
    
    //serie
    Route::get('series', ['uses' => 'SerieController@getAllSerieByPage']);
    Route::get('privacies', ['uses' => 'PrivacyController@getAll']);
    Route::post('check', ['uses' => 'AuthController@checkToken']);

    // comment
    Route::get('comments', ['uses' => 'CommentController@allCmt']);

    Route::post('mail/send', ['uses' => 'MailController@sendMail']);

    //tag
    Route::get('tags', ['uses' => 'TagController@findTags']);
    //verify
    Route::get('/verify/{token}', [AuthController::class, 'verify'])->name('verify');

    ///test
    Route::get('/test-email', function () {
        Mail::raw('Test email body', function ($message) {
            $message->to('bmv.buiminhvu@gmail.com')
                ->subject('Test Email');
        });

        return 'Email sent';
    });

    Route::get('/test-redis', function () {
        try {
            \Illuminate\Support\Facades\Redis::set('field1', 'value1');
            return \Illuminate\Support\Facades\Redis::get('field1');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    });
});
