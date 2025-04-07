<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\GcaddonRequest;
use App\Models\Gcaddon;
use App\Services\GcaddonService;
use Exception;

class GcaddonController extends Controller
{
    protected $gcaddonService;

    public function __construct(GcaddonService $gcaddonService)
    {
        $this->gcaddonService = $gcaddonService;
    }

    public function index()
    {
        try {
            $data = Gcaddon::with(['gc'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch gcaddon data', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Gcaddon::with(['gc'])->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Gcaddon not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching gcaddon', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(GcaddonRequest $request)
    {
        try {
            $data = $request->validated();
            $gcaddon = $this->gcaddonService->create($data);
            return $this->sendResponse($gcaddon, 201, 'Gcaddon created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create gcaddon', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(GcaddonRequest $request, $id)
    {
        try {
            $addon = Gcaddon::find($id);
            if (!$addon) return $this->sendError('Gcaddon not found', 404);

            $updated = $this->gcaddonService->update($addon, $request->validated());
            return $this->sendResponse($updated, 200, 'Gcaddon updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update gcaddon', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $addon = Gcaddon::find($id);
            if (!$addon) return $this->sendError('Gcaddon not found', 404);

            $addon->active = !$addon->active;
            $addon->save();
            return $this->sendResponse([], 200, 'Gcaddon visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
