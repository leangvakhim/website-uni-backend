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
            $data = RsdMeet::with('rsdm_rsdtitle')->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve list', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $item = RsdMeet::with('rsdm_rsdtitle')->find($id);
            if (!$item) return $this->sendError('RSD Meet not found', 404);
            return $this->sendResponse($item);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(RsdMeetRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdRsdMeet = [];

            if (isset($validated['research_meet']) && is_array($validated['research_meet'])) {
                foreach ($validated['research_meet'] as $item) {
                    $item['rsdm_rsdtile'] = $item['rsdm_rsdtile'] ?? null;
                    $item['rsdm_detail'] = $item['rsdm_detail'] ?? null;
                    $item['rsdm_img'] = $item['rsdm_img'] ?? null;

                    $createdRsdMeet[] = RsdMeet::create($item);
                }
            }

            return $this->sendResponse($createdRsdMeet, 201, 'RsdMeet records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create RsdMeet', 500, ['error' => $e->getMessage()]);
        }
    }
    public function update(RsdMeetRequest $request, $id)
    {
        try {
            $RsdMeet = RsdMeet::find($id);
            if (!$RsdMeet) {
                return $this->sendError('RsdMeet not found', 404);
            }

            $request->merge($request->input('research_meet'));

            $validated = $request->validate([
                'rsdm_rsdtile' => 'nullable|integer|exists:tbrsd_title,rsdt_id',
                'rsdm_detail' => 'nullable|string',
                'rsdm_img' => 'nullable|integer|exists:tbimage,image_id',
            ]);

            $RsdMeet->update($validated);

            return $this->sendResponse($RsdMeet, 200, 'RsdMeet updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update RsdMeet', 500, ['error' => $e->getMessage()]);
        }
    }

}

