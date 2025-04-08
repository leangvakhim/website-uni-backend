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
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'Academic created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(AcademicRequest $request, $id)
    {
        try {
            $item = Academic::find($id);
            if (!$item) return $this->sendError('Not found', 404);
            $updated = $this->service->update($item, $request->validated());
            return $this->sendResponse($updated, 200, 'Updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
