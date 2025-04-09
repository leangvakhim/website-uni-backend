<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Section;
use App\Http\Requests\SectionRequest;
use App\Services\SectionService;
use Exception;
use Illuminate\Http\Request;

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
            $validated = $request->validated();
            $createdSections = [];

            if (isset($validated['sections']) && is_array($validated['sections'])) {
                foreach ($validated['sections'] as $item) {
                    if (!isset($item['sec_order'])) {
                        $item['sec_order'] = (Section::where('sec_page', $item['sec_page'])->max('sec_order') ?? 0) + 1;
                    }

                    $item['lang'] = $item['lang'] ?? 1;
                    $item['display'] = $item['display'] ?? 1;
                    $item['active'] = $item['active'] ?? 1;

                    $createdSections[] = Section::create($item);
                }
            }

            return $this->sendResponse($createdSections, 201, 'Section records created successfully');
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

    public function getByPage($p_id)
    {
        $sections = Section::where('sec_page', $p_id)
            ->where('active', 1)
            ->orderBy('sec_order')
            ->get();

        return response()->json(['data' => $sections]);
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            '*.sec_id' => 'required|integer|exists:tbsection,sec_id',
            '*.sec_order' => 'required|integer'
        ]);

        foreach ($data as $item) {
            Section::where('sec_id', $item['sec_id'])->update(['sec_order' => $item['sec_order']]);
        }

        return response()->json([
            'message' => 'Section order updated successfully',
        ], 200);
    }
}
