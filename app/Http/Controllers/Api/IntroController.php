<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Intro;
use App\Http\Requests\IntroRequest;
use App\Services\IntroService;
use Exception;

class IntroController extends Controller
{
    protected $service;

    public function __construct(IntroService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Intro::with(['section', 'image'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load Intro data', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $intro = Intro::with(['section', 'image'])->find($id);
            if (!$intro) {
                return $this->sendError('Intro not found', 404);
            }
            return $this->sendResponse($intro);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve Intro', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(IntroRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdIntro = [];

            if (isset($validated['introduction']) && is_array($validated['introduction'])) {
                foreach ($validated['introduction'] as $item) {

                    $item['in_sec'] = $item['in_sec'] ?? null;
                    $item['in_title'] = $item['in_title'] ?? null;
                    $item['in_detail'] = $item['in_detail'] ?? null;
                    $item['in_img'] = $item['in_img'] ?? null;
                    $item['inadd_title'] = $item['inadd_title'] ?? null;
                    $item['in_addsubtitle'] = $item['in_addsubtitle'] ?? null;

                    $createdIntro[] = Intro::create($item);
                }
            }

            return $this->sendResponse($createdIntro, 201, 'Introduction records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Introduction', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(IntroRequest $request, $id)
    {
        try {
            $intro = Intro::find($id);
            if (!$intro) {
                return $this->sendError('Intro not found', 404);
            }

            $request->merge($request->input('introduction'));

            $validated = $request->validate([
                'in_sec' => 'nullable|integer|exists:tbsection,sec_id',
                'in_title' => 'nullable|string|max:255',
                'in_detail' => 'nullable|string',
                'in_img' => 'nullable|integer|exists:tbimage,image_id',
                'inadd_title' => 'nullable|string|max:50',
                'in_addsubtitle' => 'nullable|string|max:50',
            ]);

            $intro->update($validated);

            return $this->sendResponse($intro, 200, 'Intro updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Intro', 500, ['error' => $e->getMessage()]);
        }
    }
}
