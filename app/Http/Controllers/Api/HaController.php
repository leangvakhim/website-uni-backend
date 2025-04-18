<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Ha;
use App\Http\Requests\HaRequest;
use App\Services\HaService;
use Exception;

class HaController extends Controller
{
    protected $service;

    public function __construct(HaService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Ha::with(['section', 'image'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load HA data', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $ha = Ha::with(['section', 'image'])->find($id);
            if (!$ha) {
                return $this->sendError('HA not found', 404);
            }
            return $this->sendResponse($ha);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve HA', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(HaRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdHa = [];

            if (isset($validated['apply']) && is_array($validated['apply'])) {
                foreach ($validated['apply'] as $item) {

                    $item['ha_sec'] = $item['ha_sec'] ?? null;
                    $item['ha_title'] = $item['ha_title'] ?? null;
                    $item['ha_img'] = $item['ha_img'] ?? null;
                    $item['ha_tagtitle'] = $item['ha_tagtitle'] ?? null;
                    $item['ha_subtitletag'] = $item['ha_subtitletag'] ?? null;
                    $item['ha_date'] = $item['ha_date'] ?? null;

                    $createdHa[] = Ha::create($item);
                }
            }

            return $this->sendResponse($createdHa, 201, 'Ha records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create ha', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(HaRequest $request, $id)
    {
        try {
            $ha = Ha::find($id);
            if (!$ha) {
                return $this->sendError('Ha not found', 404);
            }

            $request->merge($request->input('ha'));

            $validated = $request->validate([
                'ha_sec' => 'nullable|integer|exists:tbsection,sec_id',
                'ha_title' => 'nullable|string|max:255',
                'ha_img' => 'nullable|integer|exists:tbimage,image_id',
                'ha_tagtitle' => 'nullable|string|max:255',
                'ha_subtitletag' => 'nullable|string|max:255',
                'ha_date' => 'nullable|date',
            ]);

            $ha->update($validated);

            return $this->sendResponse($ha, 200, 'Ha updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update ha', 500, ['error' => $e->getMessage()]);
        }
    }
}
