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
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'Department created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create department', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(DepartmentRequest $request, $id)
    {
        try {
            $department = Department::find($id);
            if (!$department) return $this->sendError('Department not found', 404);

            $updated = $this->service->update($department, $request->validated());
            return $this->sendResponse($updated, 200, 'Department updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update department', 500, ['error' => $e->getMessage()]);
        }
    }
}
