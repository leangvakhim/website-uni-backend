<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\RsdMeet;
use App\Services\RsdMeetService;
use App\Http\Requests\RsdMeetRequest;
use Exception;

class RsdMeetController extends Controller
{
    protected $rsdMeetService;

    public function __construct(RsdMeetService $rsdMeetService)
    {
        $this->rsdMeetService = $rsdMeetService;
    }

    public function index()
    {
        try {
            $data = RsdMeet::with('faculty:fc_id,fc_name,fc_order,display,active')->where('active', 1)->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve list', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $item = RsdMeet::with('faculty:fc_id,fc_name,fc_order,display,active    ')->find($id);
            if (!$item) return $this->sendError('RSD Meet not found', 404);
            return $this->sendResponse($item);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(RsdMeetRequest $request)
    {
        try {
            $rsdm = $this->rsdMeetService->create($request->validated());
            return $this->sendResponse($rsdm, 201, 'Created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RsdMeetRequest $request, $id)
    {
        try {
            $rsdm = RsdMeet::find($id);
            if (!$rsdm) return $this->sendError('Not found', 404);

            $updated = $this->rsdMeetService->update($rsdm, $request->validated());
            return $this->sendResponse($updated, 200, 'Updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $rsdm = RsdMeet::find($id);
            if (!$rsdm) return $this->sendError('Not found', 404);

            $rsdm->active = !$rsdm->active;
            $rsdm->save();

            return $this->sendResponse([], 200, 'Visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}

