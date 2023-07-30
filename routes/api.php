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
