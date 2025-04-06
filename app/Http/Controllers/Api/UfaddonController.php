<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\UfaddonRequest;
use App\Models\Ufaddon;
use App\Services\UfaddonService;
use Exception;

class UfaddonController extends Controller
{
    protected $ufaddonService;

    public function __construct(UfaddonService $ufaddonService)
    {
        $this->ufaddonService = $ufaddonService;
    }

    public function index()
    {
        try {
            $data = Ufaddon::with('uf')->where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch Ufaddon data', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Ufaddon::with('uf')->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Ufaddon not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching Ufaddon', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(UfaddonRequest $request)
    {
        try {
            $data = $request->validated();
            if (!isset($data['ufa_order'])) {
                $data['ufa_order'] = Ufaddon::max('ufa_order') + 1;
            }
            $ufaddon = app(UfaddonService::class)->create($data);
            return $this->sendResponse($ufaddon, 201, 'Ufaddon created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Ufaddon', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(UfaddonRequest $request, $id)
    {
        try {
            $ufaddon = Ufaddon::find($id);
            if (!$ufaddon) return $this->sendError('Ufaddon not found', 404);

            $updated = $this->ufaddonService->update($ufaddon, $request->validated());
            return $this->sendResponse($updated, 200, 'Ufaddon updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Ufaddon', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $ufaddon = Ufaddon::find($id);
            if (!$ufaddon) return $this->sendError('Ufaddon not found', 404);

            $ufaddon->active = !$ufaddon->active;
            $ufaddon->save();
            return $this->sendResponse([], 200, 'Ufaddon visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
