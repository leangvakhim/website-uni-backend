<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use App\Services\SettingService;
use Exception;

class SettingController extends Controller
{
    protected $service;

    public function __construct(SettingService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $settings = Setting::with(['logo', 'social'])->get();
            return $this->sendResponse($settings);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch settings', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $setting = Setting::with(['logo', 'social'])->find($id);
            return $setting ? $this->sendResponse($setting) : $this->sendError('Setting not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching setting', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(SettingRequest $request)
    {
        try {
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'Setting created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create setting', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(SettingRequest $request, $id)
    {
        try {
            $setting = Setting::find($id);
            if (!$setting) return $this->sendError('Setting not found', 404);

            $updated = $this->service->update($setting, $request->validated());
            return $this->sendResponse($updated, 200, 'Setting updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update setting', 500, ['error' => $e->getMessage()]);
        }
    }
}
