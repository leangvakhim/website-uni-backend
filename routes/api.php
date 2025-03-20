<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TextController;
use App\Http\Controllers\Api\ButtonController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\SlideshowController;
use App\Http\Controllers\Api\SocialController;

Route::prefix('text')->group(function () {
    Route::get('/', [TextController::class, 'index']);  
    Route::get('/{id}', [TextController::class, 'show']); 
    Route::post('/create', [TextController::class, 'create']); 
    Route::post('/update/{id}', [TextController::class, 'update']); 
});

Route::prefix('button')->group(function () {
    Route::get('/', [ButtonController::class, 'index']); 
    Route::get('/{id}', [ButtonController::class, 'show']); 
    Route::post('/create', [ButtonController::class, 'create']); 
    Route::post('/update/{id}', [ButtonController::class, 'update']); 
});

Route::prefix('images')->group(function () {
    Route::get('/', [ImageController::class, 'index']); 
    Route::get('/{id}', [ImageController::class, 'show']); 
    Route::post('/create', [ImageController::class, 'create']);
    Route::post('/update/{id}', [ImageController::class, 'update']); 
    Route::delete('/delete/{id}', [ImageController::class, 'delete']);
});

Route::prefix('slideshows')->group(function () {
    Route::get('/', [SlideshowController::class, 'index']);
    Route::get('/{id}', [SlideshowController::class, 'show']);
    Route::post('/create', [SlideshowController::class, 'create']);
    Route::post('/update/{id}', [SlideshowController::class, 'update']);
    Route::put('/visibility/{id}', [SlideshowController::class, 'visibility']);
});

Route::prefix('social')->group(function () {
    Route::get('/', [SocialController::class, 'index']); 
    Route::get('/{id}', [SocialController::class, 'show']); 
    Route::post('/create', [SocialController::class, 'create']); 
    Route::post('/update/{id}', [SocialController::class, 'update']);
    Route::put('/visibility/{id}', [SocialController::class, 'visibility']); 
});


