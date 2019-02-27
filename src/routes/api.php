<?php

Route::prefix('auth')->group(function () {
    Route::post('sign-in', 'AuthController@login');
    Route::post('sign-up', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
});

Route::middleware('auth:api')->namespace('Api')->group(function () {
    Route::post('compressors/{type}', 'FileController@compress');
    Route::post('converters/{type}', 'FileController@convert');
    Route::get('archive/{uid}', 'FileController@archive');
});
