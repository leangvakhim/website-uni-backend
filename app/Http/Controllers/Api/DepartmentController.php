<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Exception;

class DepartmentController extends Controller
{
    protected $service;

    public function __construct(DepartmentService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $departments = Department::with(['section', 'image1', 'image2'])->get();
            return $this->sendResponse($departments);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch departments', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $department = Department::with(['section', 'image1', 'image2'])->find($id);
            return $department ? $this->sendResponse($department) : $this->sendError('Department not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching department', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(DepartmentRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdDepartment = [];

            if (isset($validated['programs']) && is_array($validated['programs'])) {
                foreach ($validated['programs'] as $item) {

                    $item['dep_title'] = $item['dep_title'] ?? null;
                    $item['dep_detail'] = $item['dep_detail'] ?? null;
                    $item['dep_img1'] = $item['dep_img1'] ?? null;
                    $item['dep_img2'] = $item['dep_img2'] ?? null;
                    $item['dep_sec'] = $item['dep_sec'] ?? null;

                    if (!empty($item['dep_id'])) {
                        // Update existing
                        $existing = Department::find($item['dep_id']);
                        if ($existing) {
                            $existing->update([
                                'dep_title' => $item['dep_title'],
                                'dep_detail' => $item['dep_detail'],
                                'dep_img1' => $item['dep_img1'],
                                'dep_img2' => $item['dep_img2'],
                            ]);
                            $createdDepartment[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = Department::where('dep_sec', $item['dep_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = Department::create($item);
                            $createdDepartment[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdDepartment, 201, 'Department records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update Department', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(DepartmentRequest $request, $id)
    {
        try {
            $Department = Department::find($id);
            if (!$Department) {
                return $this->sendError('Department not found', 404);
            }

            $data = $request->input('programs');

            $validated = validator($data, [
                'dep_title' => 'nullable|string|max:255',
                'dep_detail' => 'nullable|string',
                'dep_img1' => 'nullable|integer',
                'dep_img2' => 'nullable|integer',
                'dep_sec' => 'nullable|integer',
            ])->validate();

            $Department->update($validated);

            return $this->sendResponse($Department, 200, 'Department updated successfully');
            return $this->sendResponse([], 200, 'Department updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Department', 500, ['error' => $e->getMessage()]);
        }
    }
}
