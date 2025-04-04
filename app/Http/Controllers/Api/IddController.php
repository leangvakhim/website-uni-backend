<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Idd;
use App\Http\Requests\IddRequest;
use App\Services\IddService;
use Exception;

class IddController extends Controller
{
    protected $service;

    public function __construct(IddService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Idd::with('section')->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load IDDs', 500, ['error' => $e->getMessage()]);
        }
    }
    public function show(string $id)
    {
        try {
            $idd = Idd::with('section')->find($id);
            if (!$idd) {
                return $this->sendError('IDD not found', 404);
            }
            return $this->sendResponse($idd);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve IDD', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(IddRequest $request)
    {
        try {
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'Idd created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(IddRequest $request, $id)
    {
        try {
            $idd = Idd::find($id);
            if (!$idd) return $this->sendError('Not found', 404);
            $updated = $this->service->update($idd, $request->validated());
            return $this->sendResponse($updated, 200, 'Updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
