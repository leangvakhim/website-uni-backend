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
            $createdDepartments = [];

            if (isset($validated['programs']) && is_array($validated['programs'])) {
                foreach ($validated['programs'] as $item) {

                    $item['dep_title'] = $item['dep_title'] ?? null;
                    $item['dep_detail'] = $item['dep_detail'] ?? null;
                    $item['dep_img1'] = $item['dep_img1'] ?? null;
                    $item['dep_img2'] = $item['dep_img2'] ?? null;

                    $createdDepartments[] = Department::create($item);
                }
            }

            return $this->sendResponse($createdDepartments, 201, 'Department records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create department', 500, ['error' => $e->getMessage()]);
        }
    }

    // public function update(DepartmentRequest $request, $id)
    // {
    //     try {
    //         $department = Department::find($id);
    //         if (!$department) return $this->sendError('Department not found', 404);

    //         $updated = $this->service->update($department, $request->validated());
    //         return $this->sendResponse($updated, 200, 'Department updated');
    //     } catch (Exception $e) {
    //         return $this->sendError('Failed to update department', 500, ['error' => $e->getMessage()]);
    //     }
    // }
    public function update(DepartmentRequest $request, $id)
    {
        try {
            $department = Department::find($id);
            if (!$department) {
                return $this->sendError('Department not found', 404);
            }

            $request->merge($request->input('programs'));

            $validated = $request->validate([
                'dep_title' => 'required|string',
                'dep_detail' => 'nullable|string',
                'dep_img1' => 'nullable|integer',
                'dep_img2' => 'nullable|integer',
                'dep_sec' => 'nullable|integer',
            ]);

            $department->update($validated);

            return $this->sendResponse($department, 200, 'department updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update department', 500, ['error' => $e->getMessage()]);
        }
    }
}
