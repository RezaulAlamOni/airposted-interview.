<?php

use App\Models\blogs;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    return $request->user()->name;
});
Route::middleware('auth:api')->group(function () {
    Route::get('/blogs', 'BlogsController@index');
    Route::post('/blog/delete', 'BlogsController@deleteBlog');

    Route::post('/blog/create', 'BlogsController@create');


});

