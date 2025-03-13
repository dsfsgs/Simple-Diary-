<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaryController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Define API routes in web.php
Route::prefix('api')->group(function () {
    Route::apiResource('diaries', DiaryController::class);
});
