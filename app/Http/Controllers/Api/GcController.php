<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Gc;
use App\Http\Requests\GcRequest;
use App\Services\GcService;
use Exception;

class GcController extends Controller
{
    protected $service;

    public function __construct(GcService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Gc::with(['section', 'image1', 'image2'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load GC', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Gc::with(['section', 'image1', 'image2'])->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch GC', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(GcRequest $request)
    {
        try {
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'GC created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(GcRequest $request, $id)
    {
        try {
            $gc = Gc::find($id);
            if (!$gc) return $this->sendError('Not found', 404);
            $updated = $this->service->update($gc, $request->validated());
            return $this->sendResponse($updated, 200, 'Updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
