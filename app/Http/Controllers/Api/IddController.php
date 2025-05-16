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
            $validated = $request->validated();
            $createdIdd = [];

            if (isset($validated['important']) && is_array($validated['important'])) {
                foreach ($validated['important'] as $item) {

                    $item['idd_sec'] = $item['idd_sec'] ?? null;
                    $item['idd_title'] = $item['idd_title'] ?? null;
                    $item['idd_subtitle'] = $item['idd_subtitle'] ?? null;

                    if (!empty($item['idd_id'])) {
                        // Update existing
                        $existing = Idd::find($item['idd_id']);
                        if ($existing) {
                            $existing->update([
                                'idd_title' => $item['idd_title'],
                                'idd_subtitle' => $item['idd_subtitle'],
                                'idd_sec' => $item['idd_sec'],
                          
                            ]);
                            $createdIdd[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = Idd::where('idd_sec', $item['idd_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = Idd::create($item);
                            $createdIdd[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdIdd, 201, 'Idd records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update idd', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(IddRequest $request, $id)
    {
        try {
            $idd = Idd::find($id);
            if (!$idd) {
                return $this->sendError('Idd not found', 404);
            }

            $data = $request->input('important');

            $validated = $request->validate([
                'idd_title' => 'nullable|string',
                'idd_subtitle' => 'nullable|string',
                'idd_sec' => 'nullable|integer',
            ])->validate();

            $idd->update($validated);

            return $this->sendResponse($idd, 200, 'Idd updated successfully');
            return $this->sendResponse([], 200, 'Idd updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update idd', 500, ['error' => $e->getMessage()]);
        }
    }
}
