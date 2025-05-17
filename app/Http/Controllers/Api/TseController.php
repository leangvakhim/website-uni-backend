<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Tse;
use App\Http\Requests\TseRequest;
use App\Services\TseService;
use Exception;

class TseController extends Controller
{
    protected $service;

    public function __construct(TseService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Tse::with(['section', 'text'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load TSE records', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $tse = Tse::with(['section', 'text'])->find($id);
            if (!$tse) {
                return $this->sendError('TSE not found', 404);
            }
            return $this->sendResponse($tse);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve TSE', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(TseRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdTse = [];

            if (isset($validated['type']) && is_array($validated['type'])) {
                foreach ($validated['type'] as $item) {

                    $item['tse_sec'] = $item['tse_sec'] ?? null;
                    $item['tse_type'] = $item['tse_type'] ?? null;
                    $item['tse_text'] = $item['tse_text'] ?? null;

                    if (!empty($item['tse_id'])) {
                        // Update existing
                        $existing = Tse::find($item['tse_id']);
                        if ($existing) {
                            $existing->update([
                                'tse_text' => $item['tse_text'],
                                'tse_type' => $item['tse_type'],

                            ]);
                            $createdTse[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = Tse::where('tse_sec', $item['tse_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = Tse::create($item);
                            $createdTse[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdTse, 201, 'Tse records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/updated tse', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(TseRequest $request, $id)
    {
        try {
            $tse = Tse::find($id);
            if (!$tse) {
                return $this->sendError('Tse not found', 404);
            }

            $data = $request->input('type');

            $validated = validator($data,[
                'tse_text' => 'nullable|integer',
                'tse_type' => 'nullable|integer',
                'tse_sec' => 'nullable|integer',
            ])->validate();

            $tse->update($validated);

            return $this->sendResponse($tse, 200, 'Tse updated successfully');
            return $this->sendResponse([], 200, 'Tse updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Tse', 500, ['error' => $e->getMessage()]);
        }
    }
}
