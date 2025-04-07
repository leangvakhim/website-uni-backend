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
use App\Http\Controllers\Api\BtnssController;
use App\Http\Controllers\Api\Slideshow2Controller;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\CareerController;
use App\Http\Controllers\Api\RsdlController;
use App\Http\Controllers\Api\ScholarshipController;
use App\Http\Controllers\Api\RsdMeetController;
use App\Http\Controllers\Api\RsdTitleController;
use App\Http\Controllers\Api\RsdDescController;
use App\Http\Controllers\Api\RsdProjectController;
use App\Http\Controllers\Api\RsdController;
use App\Http\Controllers\Api\RsdltagController;
use App\Http\Controllers\Api\AsheadController;
use App\Http\Controllers\Api\PartnershipController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\SectionController;

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
    Route::get('/by-faculty/{f_id}', [SocialController::class, 'getByFaculty']);
    Route::post('/create', [SocialController::class, 'create']);
    Route::post('/update/{id}', [SocialController::class, 'update']);
    Route::put('/visibility/{id}', [SocialController::class, 'visibility']);
    Route::post('/reorder', [SocialController::class, 'reorder']);
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
    Route::post('/duplicate/{id}', [FacultyController::class, 'duplicate']);
    Route::put('/reorder', [FacultyController::class, 'reorder']);
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

Route::prefix('year')->group(function () {
    Route::get('/', [YearController::class, 'index']);
    Route::get('/{id}', [YearController::class, 'show']);
    Route::post('/create', [YearController::class, 'create']);
    Route::post('/update/{id}', [YearController::class, 'update']);
    Route::put('/visibility/{id}', [YearController::class, 'visibility']);
});

Route::prefix('btnss')->group(function () {
    Route::get('/', [BtnssController::class, 'index']);
    Route::get('/{id}', [BtnssController::class, 'show']);
    Route::post('/create', [BtnssController::class, 'create']);
    Route::post('/update/{id}', [BtnssController::class, 'update']);
    Route::put('/visibility/{id}', [BtnssController::class, 'visibility']);
});

Route::prefix('slideshow')->group(function () {
    Route::get('/', [Slideshow2Controller::class, 'index']);
    Route::get('/{id}', [Slideshow2Controller::class, 'show']);
    Route::post('/create', [Slideshow2Controller::class, 'create']);
    Route::post('/update/{id}', [Slideshow2Controller::class, 'update']);
    Route::put('/visibility/{id}', [Slideshow2Controller::class, 'visibility']);
});

Route::prefix('event')->group(function () {
    Route::get('/', [EventController::class, 'index']);
    Route::get('/{id}', [EventController::class, 'show']);
    Route::post('/create', [EventController::class, 'create']);
    Route::post('/update/{id}', [EventController::class, 'update']);
    Route::put('/visibility/{id}', [EventController::class, 'visibility']);
    Route::post('/duplicate/{id}', [EventController::class, 'duplicate']);
    Route::put('/reorder', [EventController::class, 'reorder']);
});

Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index']);
    Route::get('/{id}', [NewsController::class, 'show']);
    Route::post('/create', [NewsController::class, 'create']);
    Route::post('/update/{id}', [NewsController::class, 'update']);
    Route::put('/visibility/{id}', [NewsController::class, 'visibility']);
    Route::post('/duplicate/{id}', [NewsController::class, 'duplicate']);
    Route::put('/reorder', [NewsController::class, 'reorder']);
});

Route::prefix('career')->group(function () {
    Route::get('/', [CareerController::class, 'index']);
    Route::get('/{id}', [CareerController::class, 'show']);
    Route::post('/create', [CareerController::class, 'create']);
    Route::post('/update/{id}', [CareerController::class, 'update']);
    Route::put('/visibility/{id}', [CareerController::class, 'visibility']);
    Route::post('/duplicate/{id}', [CareerController::class, 'duplicate']);
    Route::put('/reorder', [CareerController::class, 'reorder']);
});

Route::prefix('rsdl')->group(function () {
    Route::get('/', [RsdlController::class, 'index']);
    Route::get('/{id}', [RsdlController::class, 'show']);
    Route::post('/create', [RsdlController::class, 'create']);
    Route::post('/update/{id}', [RsdlController::class, 'update']);
    Route::put('/visibility/{id}', [RsdlController::class, 'visibility']);
});

Route::prefix('scholarship')->group(function () {
    Route::get('/', [ScholarshipController::class, 'index']);
    Route::get('/{id}', [ScholarshipController::class, 'show']);
    Route::post('/create', [ScholarshipController::class, 'create']);
    Route::post('/update/{id}', [ScholarshipController::class, 'update']);
    Route::put('/visibility/{id}', [ScholarshipController::class, 'visibility']);
});

Route::prefix('rsd-meet')->controller(RsdMeetController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
    Route::put('/visibility/{id}', 'visibility');
});

Route::prefix('rsd-title')->group(function () {
    Route::get('/', [RsdTitleController::class, 'index']);
    Route::get('/{id}', [RsdTitleController::class, 'show']);
    Route::post('/create', [RsdTitleController::class, 'create']);
    Route::post('/update/{id}', [RsdTitleController::class, 'update']);
    Route::put('/visibility/{id}', [RsdTitleController::class, 'visibility']);
});

Route::prefix('rsd-desc')->group(function () {
    Route::get('/', [RsdDescController::class, 'index']);
    Route::get('/{id}', [RsdDescController::class, 'show']);
    Route::post('/create', [RsdDescController::class, 'create']);
    Route::post('/update/{id}', [RsdDescController::class, 'update']);
    Route::put('/visibility/{id}', [RsdDescController::class, 'visibility']);
});

Route::prefix('rsd-project')->group(function () {
    Route::get('/', [RsdProjectController::class, 'index']);
    Route::get('/{id}', [RsdProjectController::class, 'show']);
    Route::post('/create', [RsdProjectController::class, 'create']);
    Route::post('/update/{id}', [RsdProjectController::class, 'update']);
    Route::put('/visibility/{id}', [RsdProjectController::class, 'visibility']);
});

Route::prefix('rsd')->controller(RsdController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
    Route::put('/visibility/{id}', 'visibility');
});

Route::prefix('rsdltag')->group(function () {
    Route::get('/', [RsdltagController::class, 'index']);
    Route::get('/{id}', [RsdltagController::class, 'show']);
    Route::post('/create', [RsdltagController::class, 'create']);
    Route::post('/update/{id}', [RsdltagController::class, 'update']);
});

Route::prefix('ashead')->group(function () {
    Route::get('/', [AsheadController::class, 'index']);
    Route::get('/{id}', [AsheadController::class, 'show']);
    Route::post('/create', [AsheadController::class, 'create']);
    Route::post('/update/{id}', [AsheadController::class, 'update']);
});

Route::prefix('partnership')->group(function () {
    Route::get('/', [PartnershipController::class, 'index']);
    Route::get('/{id}', [PartnershipController::class, 'show']);
    Route::post('/create', [PartnershipController::class, 'create']);
    Route::post('/update/{id}', [PartnershipController::class, 'update']);
    Route::put('/visibility/{id}', [PartnershipController::class, 'visibility']);
});

Route::prefix('menu')->group(function () {
    Route::get('/', [MenuController::class, 'index']);
    Route::get('/{id}', [MenuController::class, 'show']);
    Route::post('/create', [MenuController::class, 'create']);
    Route::post('/update/{id}', [MenuController::class, 'update']);
    Route::put('/visibility/{id}', [MenuController::class, 'visibility']);
    Route::post('/duplicate/{id}', [MenuController::class, 'duplicate']);
    Route::put('/reorder', [MenuController::class, 'reorder']);
});

Route::prefix('page')->group(function () {
    Route::get('/', [PageController::class, 'index']);
    Route::get('/{id}', [PageController::class, 'show']);
    Route::post('/create', [PageController::class, 'create']);
    Route::post('/update/{id}', [PageController::class, 'update']);
    Route::put('/visibility/{id}', [PageController::class, 'visibility']);
});

Route::prefix('section')->controller(SectionController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
    Route::put('/visibility/{id}', 'visibility');
});

