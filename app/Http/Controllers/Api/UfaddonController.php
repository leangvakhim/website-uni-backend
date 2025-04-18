<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\UfaddonRequest;
use App\Models\Ufaddon;
use App\Services\UfaddonService;
use Exception;
use Illuminate\Http\Request;

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
            $data = Ufaddon::with('uf')
                ->where('active', 1)
                ->orderBy('ufa_order', 'asc')
                ->get();
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
            $validated = $request->validated();
            $subfutures = $validated['ufaddon'] ?? [];

            if (empty($subfutures)) {
                return $this->sendError('No Service Data Provided', 422);
            }

            $createdSubfutures = [];

            foreach ($subfutures as $item) {
                if (!isset($item['ufa_uf'])) {
                    return $this->sendError('Ufa ID is required', 422);
                }

                $item['ufa_order'] = (Ufaddon::where('ufa_uf', $item['ufa_uf'])->max('ufa_order') ?? 0) + 1;

                $item['ufa_title'] = $item['ufa_title'] ?? null;
                $item['ufa_subtitle'] = $item['ufa_subtitle'] ?? null;
                $item['display'] = $item['display'] ?? 1;
                $item['active'] = $item['active'] ?? 1;

                $createdSubfutures[] = Ufaddon::create($item);
            }

            return $this->sendResponse($createdSubfutures, 201, 'subfutures created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create subfutures', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(UfaddonRequest $request, $id)
    {
        try {

            $subfutures = Ufaddon::find($id);
            if (!$subfutures) {
                return $this->sendError('subfutures not found', 404);
            }

            $subfuturesData = $request->input('ufaddon');
            if (!$subfuturesData || !is_array($subfuturesData)) {
                return $this->sendError('Invalid subservice data provided', 422);
            }
            $request->merge($subfuturesData);

            $validated = $request->validate([
                'ufa_uf' => 'nullable|integer',
                'ufa_title' => 'nullable|string',
                'ufa_subtitle' => 'nullable|string',
                'display' => 'nullable|integer',
            ]);

            $subfutures->update($validated);

            return $this->sendResponse($subfutures, 200, 'subfutures updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update subfutures', 500, ['error' => $e->getMessage()]);
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

    public function reorder(Request $request)
    {
        try {
            $data = $request->validate([
                '*.ufa_id' => 'required|integer|exists:tbufaddon,ufa_id',
                '*.ufa_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Ufaddon::where('ufa_id', $item['ufa_id'])->update([
                    'ufa_order' => $item['ufa_order']
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Ufaddon order updated successfully',
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to reorder Ufaddon', 500, ['error' => $e->getMessage()]);
        }
    }
}
