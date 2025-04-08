<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\RasonRequest;
use App\Models\Rason;
use App\Services\RasonService;
use Exception;

class RasonController extends Controller
{
    protected $service;

    public function __construct(RasonService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Rason::with('ras')->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch rason data', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $rason = Rason::with('ras')->find($id);
            if (!$rason) return $this->sendError('Rason not found', 404);
            return $this->sendResponse($rason);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch rason', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(RasonRequest $request)
    {
        try {
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'Rason created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RasonRequest $request, $id)
    {
        try {
            $rason = Rason::find($id);
            if (!$rason) return $this->sendError('Rason not found', 404);
            $updated = $this->service->update($rason, $request->validated());
            return $this->sendResponse($updated, 200, 'Rason updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
