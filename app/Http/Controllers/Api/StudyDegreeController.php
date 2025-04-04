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
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'Study Degree created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
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
