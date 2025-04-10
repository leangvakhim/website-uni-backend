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
            $validated = $request->validated();
            $createdUmd = [];

            if (isset($validated['unlock']) && is_array($validated['unlock'])) {
                foreach ($validated['unlock'] as $item) {

                    $item['umd_sec'] = $item['umd_sec'] ?? null;
                    $item['umd_title'] = $item['umd_title'] ?? null;
                    $item['umd_detail'] = $item['umd_detail'] ?? null;
                    $item['umd_routepage'] = $item['umd_routepage'] ?? null;
                    $item['umd_btntext'] = $item['umd_btntext'] ?? null;
                    $item['umd_img'] = $item['umd_img'] ?? null;

                    $createdUmd[] = Umd::create($item);
                }
            }

            return $this->sendResponse($createdUmd, 201, 'Umd records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create umd', 500, ['error' => $e->getMessage()]);
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
