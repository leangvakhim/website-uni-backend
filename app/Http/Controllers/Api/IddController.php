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

                    $createdIdd[] = Idd::create($item);
                }
            }

            return $this->sendResponse($createdIdd, 201, 'Idd records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create idd', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(IddRequest $request, $id)
    {
        try {
            $idd = Idd::find($id);
            if (!$idd) {
                return $this->sendError('Idd not found', 404);
            }

            $request->merge($request->input('idd'));

            $validated = $request->validate([
                'idd_title' => 'nullable|string',
                'idd_subtitle' => 'nullable|string',
                'idd_sec' => 'nullable|integer',
            ]);

            $idd->update($validated);

            return $this->sendResponse($idd, 200, 'idd updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update idd', 500, ['error' => $e->getMessage()]);
        }
    }
}
