<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Ha;
use App\Http\Requests\HaRequest;
use App\Services\HaService;
use Exception;

class HaController extends Controller
{
    protected $service;

    public function __construct(HaService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Ha::with(['section', 'image'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load HA data', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $ha = Ha::with(['section', 'image'])->find($id);
            if (!$ha) {
                return $this->sendError('HA not found', 404);
            }
            return $this->sendResponse($ha);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve HA', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(HaRequest $request)
    {
        try {
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'HA created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(HaRequest $request, $id)
    {
        try {
            $ha = Ha::find($id);
            if (!$ha) return $this->sendError('Not found', 404);
            $updated = $this->service->update($ha, $request->validated());
            return $this->sendResponse($updated, 200, 'Updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
