<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\RsdRequest;
use App\Models\Rsd;
use App\Services\RsdService;
use Exception;

class RsdController extends Controller
{
    protected $rsdService;

    public function __construct(RsdService $rsdService)
    {
        $this->rsdService = $rsdService;
    }

    public function index()
    {
        try {
            $data = Rsd::with(['image', 'text'])->where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch RSD', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Rsd::with(['image', 'text'])->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('RSD not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching RSD', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(RsdRequest $request)
    {
        try {
            $created = $this->rsdService->create($request->validated());
            return $this->sendResponse($created, 201, 'RSD created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create RSD', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RsdRequest $request, $id)
    {
        try {
            $rsd = Rsd::find($id);
            if (!$rsd) return $this->sendError('RSD not found', 404);
            $updated = $this->rsdService->update($rsd, $request->validated());
            return $this->sendResponse($updated, 200, 'RSD updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update RSD', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $rsd = Rsd::find($id);
            if (!$rsd) return $this->sendError('RSD not found', 404);
            $rsd->active = !$rsd->active;
            $rsd->save();
            return $this->sendResponse([], 200, 'RSD visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
