<?php

use App\Http\Controllers\DetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route API untuk check email tersedia
Route::get(
    '/register/check',
    [App\Http\Controllers\Auth\RegisterController::class, 'check']
)
    ->name('api-register-check');

//Route untuk API Provinces
Route::get(
    '/provinces',
    [App\Http\Controllers\API\LocationController::class, 'provinces']
)->name('api-provinces');

//Route untuk API Regency
Route::get(
    '/regencies/{provinces_id}',
    [App\Http\Controllers\API\LocationController::class, 'regencies']
)->name('api-regencies');

//Route untuk API Check Ongkir
Route::post(
    '/check-ongkir',
    [App\Http\Controllers\API\LocationController::class, 'checkOngkir']
)->name('api-checkOngkir');

//Route untuk API Check City by id
Route::get(
    '/city_id/{city_id}',
    [App\Http\Controllers\API\LocationController::class, 'cityID']
)->name('api-city-id');
