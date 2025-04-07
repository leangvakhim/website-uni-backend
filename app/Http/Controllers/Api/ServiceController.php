<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Service;
use App\Http\Requests\ServiceRequest;
use App\Services\ServiceService;
use Exception;

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
            $data = Service::with(['section', 'image'])->get();
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
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'Service created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(ServiceRequest $request, $id)
    {
        try {
            $service = Service::find($id);
            if (!$service) return $this->sendError('Service not found', 404);

            $updated = $this->service->update($service, $request->validated());
            return $this->sendResponse($updated, 200, 'Service updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
