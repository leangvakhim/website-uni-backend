<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\RasonRequest;
use App\Models\Rason;
use App\Services\RasonService;
use Exception;

class RasonController extends Controller
{
    protected $service;

    public function __construct(RasonService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Rason::with('ras')->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch rason data', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $rason = Rason::with('ras')->find($id);
            if (!$rason) return $this->sendError('Rason not found', 404);
            return $this->sendResponse($rason);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch rason', 500, ['error' => $e->getMessage()]);
        }
    }

    // public function create(RasonRequest $request)
    // {
    //     try {
    //         $data = $this->service->create($request->validated());
    //         return $this->sendResponse($data, 201, 'Rason created');
    //     } catch (Exception $e) {
    //         return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
    //     }
    // }

    // public function update(RasonRequest $request, $id)
    // {
    //     try {
    //         $rason = Rason::find($id);
    //         if (!$rason) return $this->sendError('Rason not found', 404);
    //         $updated = $this->service->update($rason, $request->validated());
    //         return $this->sendResponse($updated, 200, 'Rason updated successfully');
    //     } catch (Exception $e) {
    //         return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
    //     }
    // }

    public function create(RasonRequest $request)
    {
        try {
            $validated = $request->validated();
            $rasons = $validated['rasons'] ?? [];

            if (empty($rasons)) {
                return $this->sendError('No rasons Data Provided', 422);
            }

            $createdRasons = [];

            foreach ($rasons as $item) {
                if (!isset($item['rason_ras'])) {
                    return $this->sendError('RAS ID is required', 422);
                }

                $item['rason_title'] = $item['rason_title'] ?? null;
                $item['rason_subtitle'] = $item['rason_subtitle'] ?? null;
                $item['rason_amount'] = $item['rason_amount'] ?? null;

                $createdRasons[] = Rason::create($item);
            }

            return $this->sendResponse($createdRasons, 201, 'RasOn created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create RasOn', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RasonRequest $request, $id)
    {
        try {

            $rason = Rason::find($id);
            if (!$rason) {
                return $this->sendError('rason not found', 404);
            }

            $rasonData = $request->input('rasons');
            if (!$rasonData || !is_array($rasonData)) {
                return $this->sendError('Invalid rason data provided', 422);
            }
            $request->merge($rasonData);

            $validated = $request->validate([
                'rason_title' => 'nullable|string',
                'rason_ras' => 'nullable|integer',
                'rason_subtitle' => 'nullable|string',
                'rason_amount' => 'nullable|string',
            ]);

            $rason->update($validated);

            return $this->sendResponse($rason, 200, 'RasOn updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update RasOn', 500, ['error' => $e->getMessage()]);
        }
    }
}
