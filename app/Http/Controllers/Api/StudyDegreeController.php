<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\StudyDegree;
use App\Http\Requests\StudyDegreeRequest;
use App\Services\StudyDegreeService;
use Exception;
use Illuminate\Support\Facades\Log;

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

                    if (!empty($item['std_id'])) {
                        // Update existing
                        $existing = StudyDegree::find($item['std_id']);
                        if ($existing) {
                            $existing->update([
                                'std_title' => $item['std_title'],
                                'std_subtitle' => $item['std_subtitle'],
                                'std_type' => $item['std_type'],
                            ]);
                            $createdStudyDegree[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = StudyDegree::where('std_sec', $item['std_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord =StudyDegree::create($item);
                            $createdStudyDegree[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdStudyDegree, 201, 'StudyDegree records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update StudyDegree', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(StudyDegreeRequest $request, $id)
    {
        try {
            $study = StudyDegree::find($id);
            if (!$study) {
                return $this->sendError('StudyDegree not found', 404);
            }
            $data = $request->input('study');

            $validated = validator($data,[
                'std_title' => 'required|string',
                'std_subtitle' => 'nullable|string',
                'std_sec' => 'nullable|integer',
                'std_type' => 'nullable|integer',
            ])->validate();

            $study->update($validated);

            return $this->sendResponse($study, 200, 'study updated successfully');
            return $this->sendResponse([], 200, 'Study updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update study', 500, ['error' => $e->getMessage()]);
        }
    }
}
