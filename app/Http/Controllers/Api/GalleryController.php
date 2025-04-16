<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use App\Services\GalleryService;
use Exception;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    protected $service;

    public function __construct(GalleryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Gallery::with(['section', 'text', 'image1', 'image2', 'image3', 'image4', 'image5'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load galleries', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $data = Gallery::with(['section', 'text', 'image1', 'image2', 'image3', 'image4', 'image5'])->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Gallery not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Failed to load gallery', 500, ['error' => $e->getMessage()]);
        }
    }
    public function create(GalleryRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdGallery = [];

            if (isset($validated['gallery']) && is_array($validated['gallery'])) {
                foreach ($validated['gallery'] as $item) {
                    Log::info('🛠 Gallery Item Before Create: ', ['item' => $item]);

                    $item['gal_text'] = $item['gal_text'] ?? null;
                    $item['gal_sec'] = $item['gal_sec'] ?? null;
                    $item['gal_img1'] = $item['gal_img1'] ?? null;
                    $item['gal_img2'] = $item['gal_img2'] ?? null;
                    $item['gal_img3'] = $item['gal_img3'] ?? null;
                    $item['gal_img4'] = $item['gal_img4'] ?? null;
                    $item['gal_img5'] = $item['gal_img5'] ?? null;

                    $createdGallery[] = Gallery::create($item);
                }
            }

            return $this->sendResponse($createdGallery, 201, 'Gallery records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create gallery', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(GalleryRequest $request, $id)
    {
        try {
            $gallery = Gallery::find($id);
            if (!$gallery) {
                return $this->sendError('Gallery not found', 404);
            }

            $request->merge($request->input('gallery'));

            $validated = $request->validate([
                'gal_text' => 'nullable|integer',
                'gal_img1' => 'nullable|integer',
                'gal_img2' => 'nullable|integer',
                'gal_img3' => 'nullable|integer',
                'gal_img4' => 'nullable|integer',
                'gal_img5' => 'nullable|integer',
                'gal_sec' => 'nullable|integer',
            ]);

            $gallery->update($validated);

            return $this->sendResponse($gallery, 200, 'Gallery updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Gallery', 500, ['error' => $e->getMessage()]);
        }
    }
}
