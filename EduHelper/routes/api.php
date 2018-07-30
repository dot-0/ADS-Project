<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('addToFav', 'UserController@addToFav');
Route::post('updateRating', 'CourseController@updateRating');
Route::post('addComment', 'CommentReplyController@addComment');
Route::post('addReply', 'CommentReplyController@addReply');