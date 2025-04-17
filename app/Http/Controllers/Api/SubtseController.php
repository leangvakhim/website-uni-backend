<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\SubtseRequest;
use App\Models\Subtse;
use App\Services\SubtseService;
use Exception;
use Illuminate\Http\Request;

class SubtseController extends Controller
{
    protected $subtseService;

    public function __construct(SubtseService $subtseService)
    {
        $this->subtseService = $subtseService;
    }

    public function index()
    {
        try {
            $data = Subtse::with(['tse'])->where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch Subtse records', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Subtse::with(['tse'])->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Subtse not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching Subtse', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(SubtseRequest $request)
    {
        try {
            $validated = $request->validated();
            $subtses = $validated['subtse'] ?? [];

            if (empty($subtses)) {
                return $this->sendError('No subtse Data Provided', 422);
            }

            $createdSubtse = [];

            foreach ($subtses as $item) {
                if (!isset($item['stse_tse'])) {
                    return $this->sendError('tse ID is required', 422);
                }

                $item['stse_order'] = (Subtse::where('stse_tse', $item['stse_tse'])->max('stse_order') ?? 0) + 1;

                $item['stse_title'] = $item['stse_title'] ?? null;
                $item['stse_detail'] = $item['stse_detail'] ?? null;
                $item['display'] = $item['display'];
                $item['active'] = $item['active'] ?? 1;

                $createdSubtse[] = Subtse::create($item);
            }

            return $this->sendResponse($createdSubtse, 201, 'subtse created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create subtse', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(SubtseRequest $request, $id)
    {
        try {

            $subtse = Subtse::find($id);
            if (!$subtse) {
                return $this->sendError('Subtse not found', 404);
            }

            $subtseData = $request->input('subtse');
            if (!$subtseData || !is_array($subtseData)) {
                return $this->sendError('Invalid subtse data provided', 422);
            }
            $request->merge($subtseData);

            $validated = $request->validate([
                'stse_tse' => 'nullable|integer',
                'stse_title' => 'nullable|string',
                'stse_detail' => 'nullable|string',
                'display' => 'nullable|boolean',
            ]);

            $subtse->update($validated);

            return $this->sendResponse($subtse, 200, 'subtse updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update subtse', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $subtse = Subtse::find($id);
            if (!$subtse) return $this->sendError('Subtse not found', 404);

            $subtse->active = !$subtse->active;
            $subtse->save();

            return $this->sendResponse([], 200, 'Subtse visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function reorder(Request $request)
    {
        try {
            $data = $request->validate([
                '*.stse_id' => 'required|integer|exists:tbsubtse,stse_id',
                '*.stse_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Subtse::where('stse_id', $item['stse_id'])->update([
                    'stse_order' => $item['stse_order']
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Subtse order updated successfully',
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to reorder Subtse', 500, ['error' => $e->getMessage()]);
        }
    }
}
