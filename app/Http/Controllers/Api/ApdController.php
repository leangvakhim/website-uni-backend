<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Apd;
use App\Http\Requests\ApdRequest;
use App\Services\ApdService;
use Exception;

class ApdController extends Controller
{
    protected $service;

    public function __construct(ApdService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Apd::with('section')->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load APDs', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $apd = Apd::with('section')->find($id);
            if (!$apd) {
                return $this->sendError('APD not found', 404);
            }
            return $this->sendResponse($apd);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve APD', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(ApdRequest $request)
    {
        try {
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'APD created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(ApdRequest $request, $id)
    {
        try {
            $apd = Apd::find($id);
            if (!$apd) return $this->sendError('Not found', 404);
            $updated = $this->service->update($apd, $request->validated());
            return $this->sendResponse($updated, 200, 'Updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}

