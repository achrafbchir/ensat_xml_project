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

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Route::prefix('auth')->group(function() {
    Route::post('register', 'AuthController@register');
});*/

Route::post('convert_csv_to_array', 'StudentController@importCSVFile');
Route::post('is_valid_dtd', 'StudentController@isValidDTD');
Route::post('is_valid_xsd', 'StudentController@isValidXSD');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
  
    Route::group([
      'middleware' => 'auth'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});