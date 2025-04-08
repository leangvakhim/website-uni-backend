<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\SubtseRequest;
use App\Models\Subtse;
use App\Services\SubtseService;
use Exception;

class SubtseController extends Controller
{
    protected $subtseService;

    public function __construct(SubtseService $subtseService)
    {
        $this->subtseService = $subtseService;
    }

    public function index()
    {
        try {
            $data = Subtse::with(['tse'])->where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch Subtse records', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Subtse::with(['tse'])->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Subtse not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching Subtse', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(SubtseRequest $request)
    {
        try {
            $data = $request->validated();

            // Auto-increment stse_order if not provided
            if (!isset($data['stse_order'])) {
                $data['stse_order'] = Subtse::max('stse_order') + 1;
            }

            $result = app(SubtseService::class)->create($data);
            return $this->sendResponse($result, 201, 'Subtse created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Subtse', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(SubtseRequest $request, $id)
    {
        try {
            $subtse = Subtse::find($id);
            if (!$subtse) return $this->sendError('Subtse not found', 404);

            $updated = $this->subtseService->update($subtse, $request->validated());
            return $this->sendResponse($updated, 200, 'Subtse updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Subtse', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $subtse = Subtse::find($id);
            if (!$subtse) return $this->sendError('Subtse not found', 404);

            $subtse->active = !$subtse->active;
            $subtse->save();

            return $this->sendResponse([], 200, 'Subtse visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
