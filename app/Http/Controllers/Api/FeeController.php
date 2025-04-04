<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Fee;
use App\Http\Requests\FeeRequest;
use App\Services\FeeService;
use Exception;

class FeeController extends Controller
{
    protected $service;

    public function __construct(FeeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Fee::with(['section', 'image'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load Fee', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Fee::with(['section', 'image'])->find($id);
            if (!$data) return $this->sendError('Fee not found', 404);
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve Fee', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(FeeRequest $request)
    {
        try {
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'Fee created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(FeeRequest $request, $id)
    {
        try {
            $model = Fee::find($id);
            if (!$model) return $this->sendError('Not found', 404);
            $updated = $this->service->update($model, $request->validated());
            return $this->sendResponse($updated, 200, 'Updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
