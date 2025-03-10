<?php

use App\Http\Controllers\Gs1DataMarkController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/history', [HistoryController::class, 'get']);

Route::post('/signup', [LoginController::class, 'signup']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/reset-password', [LoginController::class, 'resetPassword']);

Route::middleware('throttle:limit')->group(function () {
    Route::post('/get-svg', [Gs1DataMarkController::class, 'index']);
});
