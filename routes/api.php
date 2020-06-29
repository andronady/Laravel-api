<?php

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
    return $request->user();
});

Route::get('posts' , 'PostsController@index');




Route::get('posts/{id}' , 'PostsController@findById');
Route::post('posts' , 'PostsController@store');
Route::post('posts/update/{id}' , 'PostsController@update');
Route::post('posts/delete/{id}' , 'PostsController@destroy');
Route::post('logout' , 'auth@logout');

Route::group(['middleware' => 'auth:api'] , function(){
});





Route::post('/password/email' , 'ForgotPasswordController@sendResetLinkEmail');
Route::post('/password/reset' , 'ResetPasswordController@reset');

Route::post('register' , 'auth@register');
Route::post('login' , 'auth@login');


