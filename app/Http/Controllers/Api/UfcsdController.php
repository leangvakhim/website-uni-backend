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

                   if (!empty($item['uf_id'])) {
                        // Update existing
                        $existing = Ufcsd::find($item['uf_id']);
                        if ($existing) {
                            $existing->update([
                                'uf_title' => $item['uf_title'],
                                'uf_subtitle' => $item['uf_subtitle'],
                                'uf_img' => $item['uf_img'],
                            ]);
                             $createdUfcsd[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = Ufcsd::where('uf_sec', $item['uf_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = Ufcsd::create($item);
                             $createdUfcsd[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdUfcsd, 201, 'Ufcsd records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update ufcsd', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(UfcsdRequest $request, $id)
    {
        try {
            $ufcsd = Ufcsd::find($id);
            if (!$ufcsd) {
                return $this->sendError('ufcsd not found', 404);
            }

            $data = $request->input('future');

            $validated = validator( $data,[
                'uf_title' => 'nullable|string',
                'uf_subtitle' => 'nullable|string',
                'uf_img' => 'nullable|integer',
                'uf_sec' => 'nullable|integer',
            ])->validate();

            $ufcsd->update($validated);

            return $this->sendResponse($ufcsd, 200, 'ufcsd updated successfully');
            return $this->sendResponse([], 200, 'Ufcsd updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update ufcsd', 500, ['error' => $e->getMessage()]);
        }
    }
}
