<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\AcademicRequest;
use App\Models\Academic;
use App\Services\AcademicService;
use Exception;

class AcademicController extends Controller
{
    protected $service;

    public function __construct(AcademicService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Academic::with(['section', 'image'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch academic', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $item = Academic::with(['section', 'image'])->find($id);
            return $item ? $this->sendResponse($item) : $this->sendError('Academic not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Failed to load academic', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(AcademicRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdAcademics = [];

            if (isset($validated['academics']) && is_array($validated['academics'])) {
                foreach ($validated['academics'] as $item) {

                    $item['acad_title'] = $item['acad_title'] ?? null;
                    $item['acad_detail'] = $item['acad_detail'] ?? null;
                    $item['acad_img'] = $item['acad_img'] ?? null;
                    $item['acad_btntext1'] = $item['acad_btntext1'] ?? null;
                    $item['acad_btntext2'] = $item['acad_btntext2'] ?? null;
                    $item['acad_routepage'] = $item['acad_routepage'] ?? null;
                    $item['acad_routetext'] = $item['acad_routetext'] ?? null;

                    $createdAcademics[] = Academic::create($item);
                }
            }

            return $this->sendResponse($createdAcademics, 201, 'Academic records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create academic', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(AcademicRequest $request, $id)
    {
        try {
            $academic = Academic::find($id);
            if (!$academic) {
                return $this->sendError('Academic not found', 404);
            }

            $request->merge($request->input('academics'));

            $validated = $request->validate([
                'acad_title' => 'required|string',
                'acad_detail' => 'nullable|string',
                'acad_img' => 'nullable|integer',
                'acad_sec' => 'nullable|integer',
                'acad_btntext1' => 'nullable|string',
                'acad_btntext2' => 'nullable|string',
                'acad_routepage' => 'nullable|string',
                'acad_routetext' => 'nullable|string',
            ]);

            $academic->update($validated);

            return $this->sendResponse($academic, 200, 'academic updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update academic', 500, ['error' => $e->getMessage()]);
        }
    }
}
