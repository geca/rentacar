<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// locahlost:8000/api/test
Route::get('/test', [App\Http\Controllers\CountryController::class, 'test']);

Route::get('/countries', [App\Http\Controllers\CountryController::class, 'index']);
Route::post('/countries', [App\Http\Controllers\CountryController::class, 'store']);
Route::put('/countries/{id}', [App\Http\Controllers\CountryController::class, 'update']);
Route::delete('/countries/{id}', [App\Http\Controllers\CountryController::class, 'destroy']);

Route::get('/cities', [App\Http\Controllers\CityController::class, 'index']);
Route::post('/cities', [App\Http\Controllers\CityController::class, 'store']);
Route::put('/cities/{id}', [App\Http\Controllers\CityController::class, 'update']);
Route::delete('/cities/{id}', [App\Http\Controllers\CityController::class, 'destroy']);