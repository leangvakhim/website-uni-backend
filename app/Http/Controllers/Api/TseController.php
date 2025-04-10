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

                    $createdTse[] = Tse::create($item);
                }
            }

            return $this->sendResponse($createdTse, 201, 'Tse records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create tse', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(TseRequest $request, $id)
    {
        try {
            $tse = Tse::find($id);
            if (!$tse) return $this->sendError('TSE not found', 404);

            $updated = $this->service->update($tse, $request->validated());
            return $this->sendResponse($updated, 200, 'TSE updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
