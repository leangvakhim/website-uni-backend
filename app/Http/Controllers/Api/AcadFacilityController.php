<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\AcadFacility;
use App\Http\Requests\AcadFacilityRequest;
use App\Services\AcadFacilityService;
use Exception;

class AcadFacilityController extends Controller
{
    protected $service;

    public function __construct(AcadFacilityService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = AcadFacility::with(['section', 'text', 'image'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load academic facilities', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $item = AcadFacility::with(['section', 'text', 'image'])->find($id);
            if (!$item) {
                return $this->sendError('Facility not found', 404);
            }
            return $this->sendResponse($item);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve facility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function store(AcadFacilityRequest $request)
    {
        try {
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'Facility created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(AcadFacilityRequest $request, $id)
    {
        try {
            $item = AcadFacility::find($id);
            if (!$item) return $this->sendError('Facility not found', 404);

            $updated = $this->service->update($item, $request->validated());
            return $this->sendResponse($updated, 200, 'Facility updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
