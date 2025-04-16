<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\SubserviceRequest;
use App\Models\Subservice;
use App\Services\SubserviceService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubserviceController extends Controller
{
    protected $subserviceService;

    public function __construct(SubserviceService $subserviceService)
    {
        $this->subserviceService = $subserviceService;
    }

    public function index()
    {
        try {
            $data = Subservice::with(['ras', 'af', 'image'])
            ->where('active', 1)
            ->orderBy('ss_order', 'asc')
            ->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch subservice data', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Subservice::with(['ras', 'af', 'image'])->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Subservice not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching subservice', 500, ['error' => $e->getMessage()]);
        }
    }

    public function createSubserviceAF(SubserviceRequest $request)
    {
        try {
            $validated = $request->validated();
            $subservices = $validated['subservice'] ?? [];

            if (empty($subservices)) {
                return $this->sendError('No Service Data Provided', 422);
            }

            $createdSubservices = [];

            foreach ($subservices as $item) {
                if (!isset($item['ss_af'])) {
                    return $this->sendError('AcadFacility ID is required', 422);
                }

                $item['ss_order'] = (Subservice::where('ss_af', $item['ss_af'])->max('ss_order') ?? 0) + 1;

                $item['ss_title'] = $item['ss_title'] ?? null;
                $item['ss_subtitle'] = $item['ss_subtitle'] ?? null;
                $item['ss_img'] = $item['ss_img'] ?? null;
                $item['display'] = $item['display'] ?? 1;
                $item['active'] = $item['active'] ?? 1;
                $item['ss_ras'] = null;

                $createdSubservices[] = Subservice::create($item);
            }

            return $this->sendResponse($createdSubservices, 201, 'Subservice created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create slideshow', 500, ['error' => $e->getMessage()]);
        }
    }

    public function updateSubserviceAF(SubserviceRequest $request, $id)
    {
        try {

            $subservice = Subservice::find($id);
            if (!$subservice) {
                return $this->sendError('Subservice not found', 404);
            }

            $subserviceData = $request->input('subservice');
            if (!$subserviceData || !is_array($subserviceData)) {
                return $this->sendError('Invalid subservice data provided', 422);
            }
            $request->merge($subserviceData);

            $validated = $request->validate([
                'ss_af' => 'nullable|integer',
                'ss_title' => 'nullable|string',
                'ss_subtitle' => 'nullable|string',
                'ss_img' => 'nullable|integer',
            ]);

            $subservice->update($validated);

            return $this->sendResponse($subservice, 200, 'Subservice updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Subservice', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibilitySubserviceAF($id)
    {
        try {
            $sub = Subservice::find($id);
            if (!$sub) return $this->sendError('Subservice not found', 404);

            $sub->active = !$sub->active;
            $sub->save();
            return $this->sendResponse([], 200, 'Visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function createSubserviceRAS(SubserviceRequest $request)
    {
        try {
            $validated = $request->validated();
            $subservices = $validated['subservice'] ?? [];

            if (empty($subservices)) {
                return $this->sendError('No Service Data Provided', 422);
            }

            $createdSubservices = [];

            foreach ($subservices as $item) {
                if (!isset($item['ss_ras'])) {
                    return $this->sendError('AcadFacility ID is required', 422);
                }

                $item['ss_order'] = (Subservice::where('ss_ras', $item['ss_ras'])->max('ss_order') ?? 0) + 1;

                $item['ss_title'] = $item['ss_title'] ?? null;
                $item['ss_subtitle'] = $item['ss_subtitle'] ?? null;
                $item['ss_img'] = $item['ss_img'] ?? null;
                $item['display'] = $item['display'] ?? 1;
                $item['active'] = $item['active'] ?? 1;
                $item['ss_af'] = null;

                $createdSubservices[] = Subservice::create($item);
            }

            return $this->sendResponse($createdSubservices, 201, 'Subservice created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create slideshow', 500, ['error' => $e->getMessage()]);
        }
    }

    public function updateSubserviceRAS(SubserviceRequest $request, $id)
    {
        try {

            $subservice = Subservice::find($id);
            if (!$subservice) {
                return $this->sendError('Subservice not found', 404);
            }

            $subserviceData = $request->input('subservice');
            if (!$subserviceData || !is_array($subserviceData)) {
                return $this->sendError('Invalid subservice data provided', 422);
            }
            $request->merge($subserviceData);

            $validated = $request->validate([
                'ss_ras' => 'nullable|integer',
                'ss_title' => 'nullable|string',
                'ss_subtitle' => 'nullable|string',
                'ss_img' => 'nullable|integer',
            ]);

            $subservice->update($validated);

            return $this->sendResponse($subservice, 200, 'Subservice updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Subservice', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibilitySubserviceRAS($id)
    {
        try {
            $sub = Subservice::find($id);
            if (!$sub) return $this->sendError('Subservice not found', 404);

            $sub->active = !$sub->active;
            $sub->save();
            return $this->sendResponse([], 200, 'Visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function reorderSubserviceAF(Request $request)
    {
        try {
            $data = $request->validate([
                '*.ss_id' => 'required|integer|exists:tbsubservice,ss_id',
                '*.ss_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Subservice::where('ss_id', $item['ss_id'])->update([
                    'ss_order' => $item['ss_order']
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Subservice order updated successfully',
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to reorder Subservice', 500, ['error' => $e->getMessage()]);
        }
    }

    public function reorderSubserviceRAS(Request $request)
    {
        try {
            $data = $request->validate([
                '*.ss_id' => 'required|integer|exists:tbsubservice,ss_id',
                '*.ss_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Subservice::where('ss_id', $item['ss_id'])->update([
                    'ss_order' => $item['ss_order']
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Subservice order updated successfully',
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to reorder Subservice', 500, ['error' => $e->getMessage()]);
        }
    }
}
