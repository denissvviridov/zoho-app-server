<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/exchange-code', [\App\Http\Controllers\GetAccessTokenController::class, 'getAccessToken']);
Route::post('/refresh-token', [\App\Http\Controllers\GetAccessTokenController::class, 'refreshAccessToken']);
Route::post('/create-deal', [\App\Http\Controllers\CreateDealController::class, 'CreateDeal']);



