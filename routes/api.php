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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// route za sve korisnike
Route::middleware('api')->post('/register', 'Auth\RegisterController@register');
Route::middleware('api')->post('/login', 'Auth\LoginController@authenticate');
Route::middleware('api')->get('/galleries', 'GalleryController@index');

// route za autorizovane korisnike
Route::middleware('jwt')->get('/galleries/{id}', 'GalleryController@show');
Route::middleware('jwt')->post('/create', 'GalleryController@store');
Route::middleware('jwt')->put('/edit-gallery/{id}', 'GalleryController@update');
Route::middleware('jwt')->delete('/galleries/{id}', 'GalleryController@destroy');
Route::middleware('jwt')->get('/authors/{id}', 'UserController@show');
Route::middleware('jwt')->post('/comments', 'CommentController@store');
Route::middleware('jwt')->delete('/comments/{id}', 'CommentController@destroy');
Route::middleware('jwt')->delete('/images/{id}', 'ImageController@destroy');