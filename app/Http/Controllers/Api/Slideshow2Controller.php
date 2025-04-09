<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Slideshow2;
use App\Services\Slideshow2Service;
use App\Http\Requests\Slideshow2Request;
use Exception;

class Slideshow2Controller extends Controller
{
    protected $slideshow2Service;

    public function __construct(Slideshow2Service $slideshow2Service)
    {
        $this->slideshow2Service = $slideshow2Service;
    }

    public function index()
    {
        try {
            $slideshows = Slideshow2::with([
                'btn1:bss_id,bss_title,bss_routepage',
                'btn2:bss_id,bss_title,bss_routepage',
                'img:image_id,img',
                'logo:image_id,img',
                'section:sec_id,sec_page,sec_order,lang,display,active' ,
            ])->where('active', 1)->get();

            return $this->sendResponse(
                $slideshows->count() === 1 ? $slideshows->first() : $slideshows
            );
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve slideshows', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $slideshow = Slideshow2::with([
                'btn1:bss_id,bss_title,bss_routepage',
                'btn2:bss_id,bss_title,bss_routepage',
                'img:image_id,img',
                'logo:image_id,img',
                'section:sec_id,sec_page,sec_order,lang,display,active' ,
            ])->find($id);

            if (!$slideshow) {
                return $this->sendError('Slideshow not found', 404);
            }

            return $this->sendResponse($slideshow);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve slideshow', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(Slideshow2Request $request)
    {
        try {
            $validatedData = $request->validated();
            $slideshow = $this->slideshow2Service->createSlideshow($validatedData);
            return $this->sendResponse($slideshow, 201, 'Slideshow created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create slideshow', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $slideshow = Slideshow2::find($id);
            if (!$slideshow) {
                return $this->sendError('Slideshow not found', 404);
            }

            $updated = $this->slideshow2Service->updateSlideshow($slideshow, $request->all());
            return $this->sendResponse($updated, 200, 'Slideshow updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update slideshow', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $slideshow = Slideshow2::find($id);
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

    public function reorder(Request $request)
    {
        try {
            $data = $request->validate([
                '*.slider_id' => 'required|integer|exists:tbslideshow2,slider_id',
                '*.slider_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Slideshow2::where('slider_id', $item['slider_id'])->update([
                    'slider_order' => $item['slider_order']
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Slideshow order updated successfully',
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to reorder slideshow', 500, ['error' => $e->getMessage()]);
        }
    }
}
