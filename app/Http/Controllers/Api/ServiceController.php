<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Service;
use App\Http\Requests\ServiceRequest;
use App\Services\ServiceService;
use Exception;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $service;

    public function __construct(ServiceService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Service::with(['section', 'image'])
            ->where('active', 1)
            ->orderBy('s_order', 'asc')
            ->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load services', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $service = Service::with(['section', 'image'])->find($id);
            if (!$service) {
                return $this->sendError('Service not found', 404);
            }
            return $this->sendResponse($service);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve service', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(ServiceRequest $request)
    {
        try {
            $validated = $request->validated();
            $services = $validated['Service'] ?? [];

            if (empty($services)) {
                return $this->sendError('No Service Data Provided', 422);
            }

            $createdServices = [];

            foreach ($services as $item) {
                if (!isset($item['s_sec'])) {
                    return $this->sendError('Section ID is required', 422);
                }

                $item['s_order'] = (Service::where('s_sec', $item['s_sec'])->max('s_order') ?? 0) + 1;

                $item['s_title'] = $item['s_title'] ?? null;
                $item['s_subtitle'] = $item['s_subtitle'] ?? null;
                $item['display'] = $item['display'] ?? 1;
                $item['active'] = $item['active'] ?? 1;

                $createdServices[] = Service::create($item);
            }

            return $this->sendResponse($createdServices, 201, 'Service created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create service', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(ServiceRequest $request, $id)
    {
        try {
            $service = Service::find($id);
            if (!$service) {
                return $this->sendError('Service not found', 404);
            }

            $request->merge($request->input('Service'));

            $validated = $request->validate([
                's_title' => 'required|string',
                's_subtitle' => 'nullable|string',
                's_img' => 'nullable|integer',
                'display' => 'nullable|integer',
                'active' => 'nullable|integer',
                's_sec' => 'nullable|integer',
            ]);

            $service->update($validated);

            return $this->sendResponse($service, 200, 'Service updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update service', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $service = Service::find($id);
            if (!$service) {
                return $this->sendError('Service not found', 404);
            }

            $service->active = $service->active == 1 ? 0 : 1;
            $service->save();
            return $this->sendResponse([], 200, 'Service visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function reorder(Request $request)
    {
        try {
            $data = $request->validate([
                '*.s_id' => 'required|integer|exists:tbservice,s_id',
                '*.s_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Service::where('s_id', $item['s_id'])->update([
                    's_order' => $item['s_order']
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Service order updated successfully',
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to reorder service', 500, ['error' => $e->getMessage()]);
        }
    }
}
