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

Route::group(['middleware' => ['api', 'throttle:60,1']], function () {
    Route::post('steamAuth', 'SteamAuth@authenticate');
});

//Route::middleware(['api', 'throttle:100,10',])->post('steamAuth', 'SteamAuth@authenticate');
