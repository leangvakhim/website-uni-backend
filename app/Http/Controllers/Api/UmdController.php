<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Umd;
use App\Http\Requests\UmdRequest;
use App\Services\UmdService;
use Exception;

class UmdController extends Controller
{
    protected $service;

    public function __construct(UmdService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Umd::with(['section', 'image'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load UMDs', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $umd = Umd::with(['section', 'image'])->find($id);
            if (!$umd) return $this->sendError('UMD not found', 404);
            return $this->sendResponse($umd);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve UMD', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(UmdRequest $request)
    {
        try {
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'UMD created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(UmdRequest $request, $id)
    {
        try {
            $umd = Umd::find($id);
            if (!$umd) return $this->sendError('UMD not found', 404);
            $updated = $this->service->update($umd, $request->validated());
            return $this->sendResponse($updated, 200, 'UMD updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }

}
