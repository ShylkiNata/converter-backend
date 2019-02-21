<?php

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
});

Route::namespace('Api')->group(function () {
    Route::post('compressors/{type}', 'FileController@compress');
    Route::post('converters/{type}', 'FileController@convert');
    Route::get('archive/{uid}', 'FileController@archive');
});
