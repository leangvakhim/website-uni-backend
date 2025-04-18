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

    // public function create(GcaddonRequest $request)
    // {
    //     try {
    //         $data = $request->validated();
    //         $gcaddon = $this->gcaddonService->create($data);
    //         return $this->sendResponse($gcaddon, 201, 'Gcaddon created');
    //     } catch (Exception $e) {
    //         return $this->sendError('Failed to create gcaddon', 500, ['error' => $e->getMessage()]);
    //     }
    // }

    // public function update(GcaddonRequest $request, $id)
    // {
    //     try {
    //         $addon = Gcaddon::find($id);
    //         if (!$addon) return $this->sendError('Gcaddon not found', 404);

    //         $updated = $this->gcaddonService->update($addon, $request->validated());
    //         return $this->sendResponse($updated, 200, 'Gcaddon updated successfully');
    //     } catch (Exception $e) {
    //         return $this->sendError('Failed to update gcaddon', 500, ['error' => $e->getMessage()]);
    //     }
    // }

    public function create(GcaddonRequest $request)
    {
        try {
            $validated = $request->validated();
            $subgcs = $validated['gcaddon'] ?? [];

            if (empty($subgcs)) {
                return $this->sendError('No Service Data Provided', 422);
            }

            $createdSubgcs = [];

            foreach ($subgcs as $item) {
                if (!isset($item['gca_gc'])) {
                    return $this->sendError('gca ID is required', 422);
                }

                $item['gca_gc'] = $item['gca_gc'] ?? null;
                $item['gca_tag'] = $item['gca_tag'] ?? null;
                $item['gca_btntitle'] = $item['gca_btntitle'] ?? null;
                $item['gca_btnlink'] = $item['gca_btnlink'] ?? 1;

                $createdSubgcs[] = Gcaddon::create($item);
            }

            return $this->sendResponse($createdSubgcs, 201, 'gcaddon created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create gcaddon', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(GcaddonRequest $request, $id)
    {
        try {

            $gcaddon = Gcaddon::find($id);
            if (!$gcaddon) {
                return $this->sendError('gcaddon not found', 404);
            }

            $gcaddonData = $request->input('gcaddon');
            if (!$gcaddonData || !is_array($gcaddonData)) {
                return $this->sendError('Invalid gcaddon data provided', 422);
            }
            $request->merge($gcaddonData);

            $validated = $request->validate([
                'gca_gc' => 'nullable|integer',
                'gca_tag' => 'nullable|string',
                'gca_btntitle' => 'nullable|string',
                'gca_btnlink' => 'nullable|string',
            ]);

            $gcaddon->update($validated);

            return $this->sendResponse($gcaddon, 200, 'gcaddon updated successfully');
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
