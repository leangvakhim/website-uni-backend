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
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\IddController;
use App\Http\Controllers\Api\HeaderSectionController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\ApdController;
use App\Http\Controllers\Api\UmdController;
use App\Http\Controllers\Api\StudyDegreeController;
use App\Http\Controllers\Api\HaController;
use App\Http\Controllers\Api\IntroController;
use App\Http\Controllers\Api\FeeController;
use App\Http\Controllers\Api\UfcsdController;
use App\Http\Controllers\Api\SubhaController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\AcadFacilityController;
use App\Http\Controllers\Api\TseController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\SubcontactController;
use App\Http\Controllers\Api\RasController;
use App\Http\Controllers\Api\GcController;
use App\Http\Controllers\Api\GcaddonController;
use App\Http\Controllers\Api\FaqaddonController;
use App\Http\Controllers\Api\UfaddonController;
use App\Http\Controllers\Api\SubiddController;
use App\Http\Controllers\Api\SubserviceController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\AcademicController;
use App\Http\Controllers\Api\GalleryController;

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
    Route::get('/by-faculty/{f_id}', [FacultyContactController::class, 'getByFaculty']);
    Route::post('/create', [FacultyContactController::class, 'create']);
    Route::post('/update/{id}', [FacultyContactController::class, 'update']);
    Route::put('/visibility/{id}', [FacultyContactController::class, 'visibility']);
    Route::post('/reorder', [FacultyContactController::class, 'reorder']);
});

Route::prefix('faculty-bg')->group(function () {
    Route::get('/', [FacultyBgController::class, 'index']);
    Route::get('/{id}', [FacultyBgController::class, 'show']);
    Route::get('/by-faculty/{f_id}', [FacultyBgController::class, 'getByFaculty']);
    Route::post('/create', [FacultyBgController::class, 'create']);
    Route::post('/update/{id}', [FacultyBgController::class, 'update']);
    Route::put('/visibility/{id}', [FacultyBgController::class, 'visibility']);
    Route::post('/reorder', [FacultyBgController::class, 'reorder']);
});

Route::prefix('faculty-info')->group(function () {
    Route::get('/', [FacultyInfoController::class, 'index']);
    Route::get('/{id}', [FacultyInfoController::class, 'show']);
    Route::get('/by-faculty/{f_id}', [FacultyInfoController::class, 'getByFaculty']);
    Route::post('/create', [FacultyInfoController::class, 'create']);
    Route::post('/update/{id}', [FacultyInfoController::class, 'update']);
    Route::put('/visibility/{id}', [FacultyInfoController::class, 'visibility']);
    Route::post('/reorder', [FacultyInfoController::class, 'reorder']);
    
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
    Route::post('/reorder', [SubtseController::class, 'reorder']);
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
    Route::post('/reorder', [YearController::class, 'reorder']);
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
    Route::post('/reorder', [Slideshow2Controller::class, 'reorder']);
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
    Route::post('/duplicate/{id}', [RsdlController::class, 'duplicate']);
    Route::put('/reorder', [RsdlController::class, 'reorder']);
});

Route::prefix('scholarship')->group(function () {
    Route::get('/', [ScholarshipController::class, 'index']);
    Route::get('/{id}', [ScholarshipController::class, 'show']);
    Route::post('/create', [ScholarshipController::class, 'create']);
    Route::post('/update/{id}', [ScholarshipController::class, 'update']);
    Route::put('/visibility/{id}', [ScholarshipController::class, 'visibility']);
    Route::post('/duplicate/{id}', [ScholarshipController::class, 'duplicate']);
    Route::put('/reorder', [ScholarshipController::class, 'reorder']);
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
    Route::post('/duplicate/{id}', 'duplicate');
    Route::put('/reorder', 'reorder');
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
    Route::post('/duplicate/{id}', [PartnershipController::class, 'duplicate']);
    Route::put('/reorder', [PartnershipController::class, 'reorder']);
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
    Route::post('/duplicate/{id}', [PageController::class, 'duplicate']);
    Route::put('/updatepagemenu/{id}', [PageController::class, 'updatePageMenu']);
});

Route::prefix('section')->controller(SectionController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
    Route::put('/visibility/{id}', 'visibility');
    Route::get('/by-page/{p_id}', 'getByPage');
    Route::post('/reorder', 'reorder');
    Route::put('/sync-section', 'syncSection');
});

Route::prefix('feedback')->group(function () {
    Route::get('/', [FeedbackController::class, 'index']);
    Route::get('/{id}', [FeedbackController::class, 'show']);
    Route::post('/create', [FeedbackController::class, 'create']);
    Route::post('/update/{id}', [FeedbackController::class, 'update']);
    Route::put('/visibility/{id}', [FeedbackController::class, 'visibility']);
    Route::put('/reorder', [FeedbackController::class, 'reorder']);
});

Route::prefix('idd')->group(function () {
    Route::get('/', [IddController::class, 'index']);
    Route::get('/{id}', [IddController::class, 'show']);
    Route::post('/create', [IddController::class, 'create']);
    Route::post('/update/{id}', [IddController::class, 'update']);
});

Route::prefix('headersection')->group(function () {
    Route::get('/', [HeadersectionController::class, 'index']);
    Route::get('/{id}', [HeadersectionController::class, 'show']);
    Route::post('/create', [HeadersectionController::class, 'create']);
    Route::post('/update/{id}', [HeadersectionController::class, 'update']);
});

Route::prefix('faq')->controller(FaqController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
});

Route::prefix('apd')->controller(ApdController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
});

Route::prefix('umd')->controller(UmdController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
});

Route::prefix('study-degree')->controller(StudyDegreeController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
});

Route::prefix('ha')->controller(HaController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
});

Route::prefix('intro')->controller(IntroController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
});

Route::prefix('fee')->controller(FeeController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{id}', 'show');
    Route::post('create', 'create');
    Route::post('update/{id}', 'update');
});

Route::prefix('ufcsd')->controller(UfcsdController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{id}', 'show');
    Route::post('create', 'create');
    Route::post('/update/{id}', 'update');
});

Route::prefix('subha')->group(function () {
    Route::get('/', [SubhaController::class, 'index']);
    Route::get('/{id}', [SubhaController::class, 'show']);
    Route::post('/create', [SubhaController::class, 'create']);
    Route::post('/update/{id}', [SubhaController::class, 'update']);
    Route::put('/visibility/{id}', [SubhaController::class, 'visibility']);
    Route::post('/reorder', [SubhaController::class, 'reorder']);
});

Route::prefix('service')->group(function () {
    Route::get('/', [ServiceController::class, 'index']);
    Route::get('/{id}', [ServiceController::class, 'show']);
    Route::post('/create', [ServiceController::class, 'create']);
    Route::post('/update/{id}', [ServiceController::class, 'update']);
    Route::post('/reorder', [ServiceController::class, 'reorder']);
});

Route::prefix('testimonial')->group(function () {
    Route::get('/', [TestimonialController::class, 'index']);
    Route::get('/{id}', [TestimonialController::class, 'show']);
    Route::post('/create', [TestimonialController::class, 'create']);
    Route::post('/update/{id}', [TestimonialController::class, 'update']);
});


Route::prefix('banner')->group(function () {
    Route::get('/', [BannerController::class, 'index']);
    Route::get('/{id}', [BannerController::class, 'show']);
    Route::post('/create', [BannerController::class, 'store']);
    Route::post('/update/{id}', [BannerController::class, 'update']);
});

Route::prefix('acad-facilities')->group(function () {
    Route::get('/', [AcadFacilityController::class, 'index']);
    Route::get('/{id}', [AcadFacilityController::class, 'show']);
    Route::post('/create', [AcadFacilityController::class, 'create']);
    Route::post('/update/{id}', [AcadFacilityController::class, 'update']);
});

Route::prefix('tse')->group(function () {
    Route::get('/', [TseController::class, 'index']);
    Route::get('/{id}', [TseController::class, 'show']);
    Route::post('/create', [TseController::class, 'create']);
    Route::post('/update/{id}', [TseController::class, 'update']);
});

Route::prefix('contact')->group(function () {
    Route::get('/', [ContactController::class, 'index']);
    Route::get('/{id}', [ContactController::class, 'show']);
    Route::post('/create', [ContactController::class, 'create']);
    Route::post('/update/{id}', [ContactController::class, 'update']);
});

Route::prefix('subcontact')->group(function () {
    Route::get('/', [SubcontactController::class, 'index']);
    Route::get('/{id}', [SubcontactController::class, 'show']);
    Route::post('/create', [SubcontactController::class, 'create']);
    Route::post('/update/{id}', [SubcontactController::class, 'update']);
    Route::put('/visibility/{id}', [SubcontactController::class, 'visibility']);
    Route::post('/reorder', [SubcontactController::class, 'reorder']);
});

Route::prefix('ras')->controller(RasController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
});

Route::prefix('gc')->controller(GcController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
});

Route::prefix('gcaddon')->controller(GcaddonController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
});

Route::prefix('subapd')->controller(SubapdController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
    Route::put('/visibility/{id}', 'visibility');
    Route::post('/reorder', 'reorder');
});

Route::prefix('faqaddon')->controller(FaqaddonController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
    Route::put('/visibility/{id}', 'visibility');
    Route::post('/reorder', 'reorder');
});

Route::prefix('ufaddon')->controller(UfaddonController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
    Route::put('/visibility/{id}', 'visibility');
    Route::post('/reorder', 'reorder');
});

Route::prefix('subidd')->controller(SubiddController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
    Route::put('/visibility/{id}', 'visibility');
    Route::post('/reorder', 'reorder');
});

Route::prefix('subservice')->controller(SubserviceController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
    Route::put('/visibility/{id}', 'visibility');
    Route::post('/reorder', 'reorder');
});

Route::prefix('setting')->controller(SettingController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
});

Route::prefix('department')->controller(DepartmentController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
});

Route::prefix('academic')->group(function () {
    Route::get('/', [AcademicController::class, 'index']);
    Route::get('/{id}', [AcademicController::class, 'show']);
    Route::post('/create', [AcademicController::class, 'create']);
    Route::post('/update/{id}', [AcademicController::class, 'update']);
});

Route::prefix('gallery')->controller(GalleryController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
});