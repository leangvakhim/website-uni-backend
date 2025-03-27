<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TextController;
use App\Http\Controllers\Api\ButtonController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\SlideshowController;
use App\Http\Controllers\Api\SocialController;
use App\Http\Controllers\Api\FacultyContactController;
use App\Http\Controllers\Api\FacultyBgController;
use App\Http\Controllers\Api\FacultyInfoController;
use App\Http\Controllers\Api\FacultyController;
use App\Http\Controllers\Api\SubtseController;
use App\Http\Controllers\Api\RasonController;
use App\Http\Controllers\Api\SubapdController;
use App\Http\Controllers\Api\YearController;

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

Route::prefix('faculty-contact')->group(function () {
    Route::get('/', [FacultyContactController::class, 'index']);
    Route::get('/{id}', [FacultyContactController::class, 'show']);
    Route::post('/create', [FacultyContactController::class, 'create']);
    Route::post('/update/{id}', [FacultyContactController::class, 'update']);
    Route::put('/visibility/{id}', [FacultyContactController::class, 'visibility']);
});

Route::prefix('faculty-bg')->group(function () {
    Route::get('/', [FacultyBgController::class, 'index']);
    Route::get('/{id}', [FacultyBgController::class, 'show']);
    Route::post('/create', [FacultyBgController::class, 'create']);
    Route::post('/update/{id}', [FacultyBgController::class, 'update']);
    Route::put('/visibility/{id}', [FacultyBgController::class, 'visibility']);
});

Route::prefix('faculty-info')->group(function () {
    Route::get('/', [FacultyInfoController::class, 'index']);
    Route::get('/{id}', [FacultyInfoController::class, 'show']);
    Route::post('/create', [FacultyInfoController::class, 'create']);
    Route::post('/update/{id}', [FacultyInfoController::class, 'update']);
    Route::put('/visibility/{id}', [FacultyInfoController::class, 'visibility']);
});

Route::prefix('faculty')->group(function () {
    Route::get('/', [FacultyController::class, 'index']);
    Route::get('/{id}', [FacultyController::class, 'show']);
    Route::post('/create', [FacultyController::class, 'create']);
    Route::post('/update/{id}', [FacultyController::class, 'update']);
    Route::put('/visibility/{id}', [FacultyController::class, 'visibility']);
});

Route::prefix('subtse')->group(function () {
    Route::get('/', [SubtseController::class, 'index']);
    Route::get('/{id}', [SubtseController::class, 'show']);
    Route::post('/create', [SubtseController::class, 'create']);
    Route::post('/update/{id}', [SubtseController::class, 'update']);
    Route::put('/visibility/{id}', [SubtseController::class, 'visibility']);
});

Route::prefix('rason')->group(function () {
    Route::get('/', [RasonController::class, 'index']);
    Route::get('/{id}', [RasonController::class, 'show']);
    Route::post('/create', [RasonController::class, 'create']);
    Route::post('/update/{id}', [RasonController::class, 'update']);
    Route::put('/visibility/{id}', [RasonController::class, 'visibility']);
});
