<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// TODO: Extend default Laravel response and exception handlers to output default response to JSON
// TODO: Add versioning middleware and load different routes based on request header

// Login
// TODO: Implement login
// TODO: Implement crypto auth
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
//    Route::post('/login', 'LoginController@postLogin');
//    Route::get('/refresh-token', ['middleware' => 'jwt.refresh', 'uses' => 'LoginController@getRefreshToken']);
});

// Routes for the Notes API
// TODO: Use middleware for crypto login
Route::group(['prefix' => 'notes', 'namespace' => 'Notes'], function () {
    Route::get('/{id}/', 'NotesController@getNote');
    Route::post('/', 'NotesController@postNote');
    Route::put('/{id}/', 'NotesController@putNote');
    Route::delete('/{id}/', 'NotesController@deleteNote');
});