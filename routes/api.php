<?php

use App\Http\Controllers\HozzavaloController;
use App\Http\Controllers\ReceptController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/recept', [ReceptController::class, 'index']);

Route::post('/recept', [ReceptController::class, 'store']);

Route::get('/hozzavalo', [HozzavaloController::class, 'index']);

Route::post('/hozzavalo', [HozzavaloController::class, 'store']);