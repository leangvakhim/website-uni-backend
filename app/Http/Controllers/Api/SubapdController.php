<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\SubapdRequest;
use App\Models\Subapd;
use App\Services\SubapdService;
use Exception;

class SubapdController extends Controller
{
    protected $subapdService;

    public function __construct(SubapdService $subapdService)
    {
        $this->subapdService = $subapdService;
    }

    public function index()
    {
        try {
            $data = Subapd::with(['apd', 'image'])->where('active', 1)->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Subapd::with(['apd', 'image'])->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(SubapdRequest $request)
    {
        try {
            $data = $request->validated();
            if (!isset($data['sapd_order'])) {
                $data['sapd_order'] = Subapd::max('sapd_order') + 1;
            }

            $created = $this->subapdService->create($data);
            return $this->sendResponse($created, 201, 'Created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(SubapdRequest $request, $id)
    {
        try {
            $subapd = Subapd::find($id);
            if (!$subapd) return $this->sendError('Not found', 404);

            $updated = $this->subapdService->update($subapd, $request->validated());
            return $this->sendResponse($updated, 200, 'Updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $subapd = Subapd::find($id);
            if (!$subapd) return $this->sendError('Not found', 404);

            $subapd->active = !$subapd->active;
            $subapd->save();
            return $this->sendResponse([], 200, 'Visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}

