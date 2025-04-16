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

    public function create(AcadFacilityRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdFacilities = [];

            if (isset($validated['facilities']) && is_array($validated['facilities'])) {
                foreach ($validated['facilities'] as $item) {

                    $item['af_text'] = $item['af_text'] ?? null;
                    $item['af_sec'] = $item['af_sec'] ?? null;
                    $item['af_img'] = $item['af_img'] ?? null;

                    $createdFacilities[] = AcadFacility::create($item);
                }
            }

            return $this->sendResponse($createdFacilities, 201, 'Facilities records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create facilities', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(AcadFacilityRequest $request, $id)
    {
        try {
            $acadFacility = AcadFacility::find($id);
            if (!$acadFacility) {
                return $this->sendError('AcadFacility not found', 404);
            }

            $request->merge($request->input('facilities'));

            $validated = $request->validate([
                'af_text' => 'nullable|integer',
                'af_img' => 'nullable|integer',
                'af_sec' => 'nullable|integer',
            ]);

            $acadFacility->update($validated);

            return $this->sendResponse($acadFacility, 200, 'AcadFacility updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update AcadFacility', 500, ['error' => $e->getMessage()]);
        }
    }
}
