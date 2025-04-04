<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Section;
use App\Http\Requests\SectionRequest;
use App\Services\SectionService;
use Exception;

class SectionController extends Controller
{
    protected $service;

    public function __construct(SectionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $sections = Section::with('page')->where('active', 1)->get();
            return $this->sendResponse($sections);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve sections', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $section = Section::with('page')->find($id);
            return $section ? $this->sendResponse($section) : $this->sendError('Section not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch section', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(SectionRequest $request)
    {
        try {
            $data = $request->validated();

            if (!isset($data['sec_order'])) {
                $data['sec_order'] = Section::max('sec_order') + 1;
            }

            $section = $this->service->create($data);
            return $this->sendResponse($section, 201, 'Section created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create section', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(SectionRequest $request, $id)
    {
        try {
            $section = Section::find($id);
            if (!$section) return $this->sendError('Section not found', 404);

            $updated = $this->service->update($section, $request->validated());
            return $this->sendResponse($updated, 200, 'Section updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update section', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $section = Section::find($id);
            if (!$section) return $this->sendError('Section not found', 404);

            $section->active = !$section->active;
            $section->save();
            return $this->sendResponse([], 200, 'Visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
