<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\StudyDegree;
use App\Http\Requests\StudyDegreeRequest;
use App\Services\StudyDegreeService;
use Exception;

class StudyDegreeController extends Controller
{
    protected $service;

    public function __construct(StudyDegreeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = StudyDegree::with('section')->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load Study Degrees', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $degree = StudyDegree::with('section')->find($id);
            if (!$degree) return $this->sendError('Study Degree not found', 404);
            return $this->sendResponse($degree);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve Study Degree', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(StudyDegreeRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdStudyDegree = [];

            if (isset($validated['study']) && is_array($validated['study'])) {
                foreach ($validated['study'] as $item) {

                    $item['std_sec'] = $item['std_sec'] ?? null;
                    $item['std_title'] = $item['std_title'] ?? null;
                    $item['std_subtitle'] = $item['std_subtitle'] ?? null;
                    $item['std_type'] = $item['std_type'] ?? null;

                    $createdStudyDegree[] = StudyDegree::create($item);
                }
            }

            return $this->sendResponse($createdStudyDegree, 201, 'StudyDegree records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create StudyDegree', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(StudyDegreeRequest $request, $id)
    {
        try {
            $degree = StudyDegree::find($id);
            if (!$degree) return $this->sendError('Not found', 404);
            $updated = $this->service->update($degree, $request->validated());
            return $this->sendResponse($updated, 200, 'Updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
