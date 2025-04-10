<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\RasRequest;
use App\Models\Ras;
use App\Services\RasService;
use Exception;

class RasController extends Controller
{
    protected $service;

    public function __construct(RasService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Ras::with(['section', 'text', 'image1', 'image2'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch Ras', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $ras = Ras::with(['section', 'text', 'image1', 'image2'])->find($id);
            if (!$ras) return $this->sendError('Ras not found', 404);
            return $this->sendResponse($ras);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch Ras', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(RasRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdRas = [];

            if (isset($validated['specialization']) && is_array($validated['specialization'])) {
                foreach ($validated['specialization'] as $item) {

                    $item['ras_sec'] = $item['ras_sec'] ?? null;
                    $item['ras_text'] = $item['ras_text'] ?? null;
                    $item['ras_img1'] = $item['ras_img1'] ?? null;
                    $item['ras_img2'] = $item['ras_img2'] ?? null;

                    $createdRas[] = Ras::create($item);
                }
            }

            return $this->sendResponse($createdRas, 201, 'Ras records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create ras', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RasRequest $request, $id)
    {
        try {
            $ras = Ras::find($id);
            if (!$ras) return $this->sendError('Ras not found', 404);
            $updated = $this->service->update($ras, $request->validated());
            return $this->sendResponse($updated, 200, 'Ras updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
