<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Ufcsd;
use App\Http\Requests\UfcsdRequest;
use App\Services\UfcsdService;
use Exception;

class UfcsdController extends Controller
{
    protected $service;

    public function __construct(UfcsdService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Ufcsd::with(['section', 'image'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load Ufcsd', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Ufcsd::with(['section', 'image'])->find($id);
            if (!$data) return $this->sendError('Ufcsd not found', 404);
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve Ufcsd', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(UfcsdRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdUfcsd = [];

            if (isset($validated['future']) && is_array($validated['future'])) {
                foreach ($validated['future'] as $item) {

                    $item['uf_sec'] = $item['uf_sec'] ?? null;
                    $item['uf_title'] = $item['uf_title'] ?? null;
                    $item['uf_subtitle'] = $item['uf_subtitle'] ?? null;
                    $item['uf_img'] = $item['uf_img'] ?? null;

                    $createdUfcsd[] = Ufcsd::create($item);
                }
            }

            return $this->sendResponse($createdUfcsd, 201, 'Ufcsd records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create ufcsd', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(UfcsdRequest $request, $id)
    {
        try {
            $ufcsd = Ufcsd::find($id);
            if (!$ufcsd) {
                return $this->sendError('Ufcsd not found', 404);
            }

            $request->merge($request->input('ufcsd'));

            $validated = $request->validate([
                'uf_sec' => 'nullable|integer|exists:tbsection,sec_id',
                'uf_title' => 'nullable|string|max:255',
                'uf_subtitle' => 'nullable|string',
                'uf_img' => 'nullable|integer|exists:tbimage,image_id', 
            ]);

            $ufcsd->update($validated);

            return $this->sendResponse($ufcsd, 200, 'ufcsd updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update ufcsd', 500, ['error' => $e->getMessage()]);
        }
    }
}
