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
            $validated = $request->validated();
            $createdApd = [];

            if (isset($validated['available']) && is_array($validated['available'])) {
                foreach ($validated['available'] as $item) {

                    $item['apd_sec'] = $item['apd_sec'] ?? null;
                    $item['apd_title'] = $item['apd_title'] ?? null;

                     if (!empty($item['apd_id'])) {
                        // Update existing
                        $existing = Apd::find($item['apd_id']);
                        if ($existing) {
                            $existing->update([
                                'apd_title' => $item['apd_title'],

                            ]);
                            $createdApd[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = Apd::where('apd_sec', $item['apd_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = Apd::create($item);
                            $createdApd[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdApd, 201, 'Apd records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update apd', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(ApdRequest $request, $id)
    {
        try {
            $apd = Apd::find($id);
            if (!$apd) {
                return $this->sendError('Apd not found', 404);
            }

             $data = $request->input('available');


            $validated = validator($data, [
                'apd_title' => 'required|string',
                'apd_sec' => 'nullable|integer',
            ])->validate();

            $apd->update($validated);

            return $this->sendResponse($apd, 200, 'apd updated successfully');
            return $this->sendResponse([], 200, 'apd updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update apd', 500, ['error' => $e->getMessage()]);
        }
    }
}

