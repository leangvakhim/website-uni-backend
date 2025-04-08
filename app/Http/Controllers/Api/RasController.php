<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\RasRequest;
use App\Models\Ras;
use App\Services\RasService;
use Exception;

class RasController extends Controller
{
    protected $service;

    public function __construct(RasService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Ras::with(['section', 'text', 'image1', 'image2'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch Ras', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $ras = Ras::with(['section', 'text', 'image1', 'image2'])->find($id);
            if (!$ras) return $this->sendError('Ras not found', 404);
            return $this->sendResponse($ras);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch Ras', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(RasRequest $request)
    {
        try {
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'Ras created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RasRequest $request, $id)
    {
        try {
            $ras = Ras::find($id);
            if (!$ras) return $this->sendError('Ras not found', 404);
            $updated = $this->service->update($ras, $request->validated());
            return $this->sendResponse($updated, 200, 'Ras updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
