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
            $createdAcadFacility = [];

            if (isset($validated['facilities']) && is_array($validated['facilities'])) {
                foreach ($validated['facilities'] as $item) {

                    $item['af_text'] = $item['af_text'] ?? null;
                    $item['af_sec'] = $item['af_sec'] ?? null;
                    $item['af_img'] = $item['af_img'] ?? null;


                    if (!empty($item['af_id'])) {
                        // Update existing
                        $existing = AcadFacility::find($item['af_id']);
                        if ($existing) {
                            $existing->update([
                                'af_text' => $item['af_text'],
                                'af_sec' => $item['af_sec'],
                                'af_img' => $item['af_img'],
                            ]);
                            $createdAcadFacility[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = AcadFacility::where('af_sec', $item['af_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = AcadFacility::create($item);
                            $createdAcadFacility[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdAcadFacility, 201, 'AcadFacility records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update AcadFacility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(AcadFacilityRequest $request, $id)
    {
        try {
            $AcadFacility = AcadFacility::find($id);
            if (!$AcadFacility) {
                return $this->sendError('AcadFacility not found', 404);
            }

            $data = $request->input('facilities');

            $validated = validator($data, [
                'af_text' => 'nullable|integer',
                'af_img' => 'nullable|integer',
                'af_sec' => 'nullable|integer',
            ])->validate();

            $AcadFacility->update($validated);

            return $this->sendResponse($AcadFacility, 200, 'AcadFacility updated successfully');
            return $this->sendResponse([], 200, 'AcadFacility updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update AcadFacility', 500, ['error' => $e->getMessage()]);
        }
    }
}
