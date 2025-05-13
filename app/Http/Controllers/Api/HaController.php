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

                    if (!empty($item['ha_id'])) {
                        // Update existing
                        $existing = Ha::find($item['ha_id']);
                        if ($existing) {
                            $existing->update([
                                'ha_title' => $item['ha_title'],
                                'ha_img' => $item['ha_img'],
                                'ha_tagtitle' => $item['ha_tagtitle'],
                                'ha_subtitletag' => $item['ha_subtitletag'],
                                'ha_date' => $item['ha_date'],
                            
                            ]);
                            $createdHa[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = Ha::where('ha_sec', $item['ha_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = Ha::create($item);
                            $createdHa[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdHa, 201, 'Ha records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update ha', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(HaRequest $request, $id)
    {
        try {
            $ha = Ha::find($id);
            if (!$ha) {
                return $this->sendError('Ha not found', 404);
            }

            $data = $request->input('apply');

            $validated = $request->validate([
                'ha_sec' => 'nullable|integer',
                'ha_title' => 'nullable|string',
                'ha_img' => 'nullable|integer',
                'ha_tagtitle' => 'nullable|string',
                'ha_subtitletag' => 'nullable|string',
                'ha_date' => 'nullable|date',
            ])->validate();

            $ha->update($validated);

            return $this->sendResponse($ha, 200, 'Ha updated successfully');
            return $this->sendResponse([], 200, 'Ha updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update ha', 500, ['error' => $e->getMessage()]);
        }
    }
}
