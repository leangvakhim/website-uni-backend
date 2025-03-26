<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Slideshow;
use App\Services\SlideshowService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SlideshowRequest;
use Exception;

class SlideshowController extends Controller
{
    protected $slideshowService;

    public function __construct(SlideshowService $slideshowService)
    {
        $this->slideshowService = $slideshowService;
    }

    public function index()
    {
        try {
            $slideshows = Slideshow::with([
                'btn1:button_id,btn_title,btn_url',
                'btn2:button_id,btn_title,btn_url',
                'img:image_id,img',
                'logo:image_id,img',
                'slider_text:text_id,title,desc,tag,lang'
            ])->where('active', 1)->get();

            // If there is only ONE record, return as an object instead of an array
            return $this->sendResponse(
                $slideshows->count() === 1 ? $slideshows->first() : $slideshows
            );
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve slideshows', 500, ['error' => $e->getMessage()]);
        }
    }

    // Get a single slideshow by ID with related data
    public function show(string $id)
    {
        try {
            $slideshow = Slideshow::with([
                'btn1:button_id,btn_title,btn_url',
                'btn2:button_id,btn_title,btn_url',
                'img:image_id,img',
                'logo:image_id,img',
                'slider_text:text_id,title,desc,tag,lang'
            ])->find($id);

            if (!$slideshow) {
                return $this->sendError('Slideshow not found', 404);
            }

            return $this->sendResponse($slideshow);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve slideshow', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(SlideshowRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $slideshow = $this->slideshowService->createSlideshow($validatedData);
            return $this->sendResponse($slideshow, 201, 'Slideshow created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create slideshow', 500, ['error' => $e->getMessage()]);
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $slideshow = Slideshow::find($id);
            if (!$slideshow) {
                return $this->sendError('Slideshow not found', 404);
            }

            $updated = $this->slideshowService->updateSlideshow($slideshow, $request->all());
            return $this->sendResponse($updated, 200, 'Slideshow updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update slideshow', 500, ['error' => $e->getMessage()]);
        }
    }

    // Toggle slideshow visibility
    public function visibility($id)
    {
        try {
            $slideshow = Slideshow::find($id);
            if (!$slideshow) {
                return $this->sendError('Slideshow not found', 404);
            }
            $slideshow->active = $slideshow->active == 1 ? 0 : 1;
            $slideshow->save();
            return $this->sendResponse([], 200, 'Slideshow visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
