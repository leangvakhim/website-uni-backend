<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\SubcontactRequest;
use App\Models\Subcontact;
use App\Services\SubcontactService;
use Exception;

class SubcontactController extends Controller
{
    protected $subcontactService;

    public function __construct(SubcontactService $subcontactService)
    {
        $this->subcontactService = $subcontactService;
    }

    public function index()
    {
        try {
            $data = Subcontact::with('image')->where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch Subcontact data', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Subcontact::with('image')->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Subcontact not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching Subcontact', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(SubcontactRequest $request)
    {
        try {
            $data = $request->validated();
            if (!isset($data['scon_order'])) {
                $data['scon_order'] = Subcontact::max('scon_order') + 1;
            }
            $subcontact = app(SubcontactService::class)->create($data);
            return $this->sendResponse($subcontact, 201, 'Subcontact created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Subcontact', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(SubcontactRequest $request, $id)
    {
        try {
            $subcontact = Subcontact::find($id);
            if (!$subcontact) return $this->sendError('Subcontact not found', 404);

            $updated = $this->subcontactService->update($subcontact, $request->validated());
            return $this->sendResponse($updated, 200, 'Subcontact updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Subcontact', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $subcontact = Subcontact::find($id);
            if (!$subcontact) return $this->sendError('Subcontact not found', 404);

            $subcontact->active = !$subcontact->active;
            $subcontact->save();
            return $this->sendResponse([], 200, 'Subcontact visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
