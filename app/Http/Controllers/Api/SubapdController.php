<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\SubapdRequest;
use App\Models\Subapd;
use App\Services\SubapdService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

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
            $data = Subapd::with(['apd', 'image'])
            ->where('active', 1)
            ->orderBy('sapd_order', 'asc')
            ->get();
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
            $validated = $request->validated();
            $createdSubApd = [];

            if (isset($validated['subapd']) && is_array($validated['subapd'])) {
                foreach ($validated['subapd'] as $item) {

                    $item['sapd_order'] = (Subapd::where('sapd_apd', $item['sapd_apd'])->max('sapd_order') ?? 0) + 1;

                    $item['sapd_apd'] = $item['sapd_apd'] ?? null;
                    $item['sapd_title'] = $item['sapd_title'] ?? null;
                    $item['sapd_img'] = $item['sapd_img'] ?? null;
                    $item['sapd_routepage'] = $item['sapd_routepage'] ?? null;
                    $item['display'] = $item['display'] ?? 1;
                    $item['active'] = $item['active'] ?? 1;

                    $createdSubApd[] = Subapd::create($item);
                }
            }

            return $this->sendResponse($createdSubApd, 201, 'Subapd records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Subapd', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(SubapdRequest $request, $id)
    {
        try {
            $subapd = Subapd::find($id);
            if (!$subapd) {
                return $this->sendError('Subapd not found', 404);
            }

            $request->merge($request->input('subapd'));

            $validated = $request->validate([
                'sapd_title' => 'required|string',
                'sapd_img' => 'nullable|integer',
                'sapd_routepage' => 'nullable|string',
                'sapd_apd' => 'nullable|integer',
                'display' => 'nullable|integer',
            ]);

            $subapd->update($validated);

            return $this->sendResponse($subapd, 200, 'subapd updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update subapd', 500, ['error' => $e->getMessage()]);
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

    public function reorder(Request $request)
    {
        try {
            $data = $request->validate([
                '*.sapd_id' => 'required|integer|exists:tbsubapd,sapd_id',
                '*.sapd_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Subapd::where('sapd_id', $item['sapd_id'])->update([
                    'sapd_order' => $item['sapd_order']
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Subapd order updated successfully',
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to reorder Subapd', 500, ['error' => $e->getMessage()]);
        }
    }
}

