<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'v1',
        'prefix' => 'v1'
    ],
    function () {
        Route::post('/register', 'AuthController@register')->name('register');
        Route::post('/login', 'AuthController@login')->name('login');
        Route::get('/refresh-token', 'AuthController@refresh');
        Route::get('/logout', 'AuthController@logout')->name('logout');
        Route::get('/get-user', 'AuthController@getUser')->name('getUser');
        Route::get('/get-token', 'AuthController@respondWithToken');

//        Route::middleware('auth:sanctum')->group(function (){

        Route::group(['prefix' => 'board'], function (){
            Route::get('/{boardModel}', 'BoardController@show');
            Route::post('/', 'BoardController@store');
            Route::get('/', 'BoardController@index');
        });

        Route::apiResource('/label', 'LabelController');

        Route::group(['prefix' => 'task'], function (){
            Route::post('/{task}/attach/label', 'TaskController@attachLabel');
            Route::post('/{task}/delete/label', 'TaskController@deleteLabel');
            Route::apiResource('/', 'TaskController');
        });
//
//            Route::group([
//                'prefix' => 'search',
//            ], function (){
//                Route::post('/task', 'SearchController@taskSearch');
//
//            });

//        });
    });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
