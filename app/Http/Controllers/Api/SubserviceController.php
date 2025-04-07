<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\SubserviceRequest;
use App\Models\Subservice;
use App\Services\SubserviceService;
use Exception;

class SubserviceController extends Controller
{
    protected $subserviceService;

    public function __construct(SubserviceService $subserviceService)
    {
        $this->subserviceService = $subserviceService;
    }

    public function index()
    {
        try {
            $data = Subservice::with(['ras', 'af', 'image'])->where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch subservice data', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Subservice::with(['ras', 'af', 'image'])->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Subservice not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching subservice', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(SubserviceRequest $request)
    {
        try {
            $data = $request->validated();
            if (!isset($data['ss_order'])) {
                $data['ss_order'] = Subservice::max('ss_order') + 1;
            }
            $sub = app(SubserviceService::class)->create($data);
            return $this->sendResponse($sub, 201, 'Subservice created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Subservice', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(SubserviceRequest $request, $id)
    {
        try {
            $sub = Subservice::find($id);
            if (!$sub) return $this->sendError('Subservice not found', 404);

            $updated = $this->subserviceService->update($sub, $request->validated());
            return $this->sendResponse($updated, 200, 'Subservice updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Subservice', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $sub = Subservice::find($id);
            if (!$sub) return $this->sendError('Subservice not found', 404);

            $sub->active = !$sub->active;
            $sub->save();
            return $this->sendResponse([], 200, 'Visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
