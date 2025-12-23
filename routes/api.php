<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/countries', [App\Http\Controllers\CountryController::class, 'index']);
Route::post('/countries', [App\Http\Controllers\CountryController::class, 'store']);
Route::put('/countries/{id}', [App\Http\Controllers\CountryController::class, 'update']);
Route::delete('/countries/{id}', [App\Http\Controllers\CountryController::class, 'destroy']);

Route::get('/cities', [App\Http\Controllers\CityController::class, 'index']);
Route::post('/cities', [App\Http\Controllers\CityController::class, 'store']);
Route::put('/cities/{id}', [App\Http\Controllers\CityController::class, 'update']);
Route::delete('/cities/{id}', [App\Http\Controllers\CityController::class, 'destroy']);

Route::get('/users', [App\Http\Controllers\UserController::class, 'index']);
Route::get('/users/{id}', [App\Http\Controllers\UserController::class, 'show']);
Route::post('/users', [App\Http\Controllers\UserController::class, 'store']);
Route::put('/users/{id}', [App\Http\Controllers\UserController::class, 'update']);
Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'destroy']);

Route::get('/cars', [App\Http\Controllers\CarController::class, 'index']);
Route::get('/cars/{id}', [App\Http\Controllers\CarController::class, 'show']);
Route::post('/cars', [App\Http\Controllers\CarController::class, 'store']);
Route::put('/cars/{id}', [App\Http\Controllers\CarController::class, 'update']);
Route::delete('/cars/{id}', [App\Http\Controllers\CarController::class, 'destroy']);