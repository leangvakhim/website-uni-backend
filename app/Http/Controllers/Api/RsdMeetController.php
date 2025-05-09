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
            $data = RsdMeet::with('title')->with('img')->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve list', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $item = RsdMeet::with('title')->with('img')->find($id);
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
            $createdRsdMeeting = [];

            if (isset($validated['research_meet']) && is_array($validated['research_meet'])) {
                foreach ($validated['research_meet'] as $item) {
                    $item['rsdm_rsdtitle'] = $item['rsdm_rsdtitle'] ?? null;
                    $item['rsdm_detail'] = $item['rsdm_detail'] ?? null;
                    $item['rsdm_title'] = $item['rsdm_title'] ?? null;
                    $item['rsdm_img'] = $item['rsdm_img'] ?? null;

                    if (!empty($item['rsdm_id'])) {
                        // Update existing
                        $existing = RsdMeet::find($item['rsdm_id']);
                        if ($existing) {
                            $existing->update([
                                'rsdm_title' => $item['rsdm_title'],
                                'rsdm_detail' => $item['rsdm_detail'],
                                'rsdm_rsdtitle' => $item['rsdm_rsdtitle'],
                                'rsdm_img' => $item['rsdm_img'],
                            ]);
                            $createdRsdMeeting[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = RsdMeet::where('rsdm_title', $item['rsdm_title'])
                            ->where('rsdm_title', $item['rsdm_title'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = RsdMeet::create($item);
                            $createdRsdMeeting[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdRsdMeeting, 201, 'RsdMeeting records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update RsdMeeting', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RsdMeetRequest $request, $id)
    {
        try {
            $RsdMeeting = RsdMeet::find($id);
            if (!$RsdMeeting) {
                return $this->sendError('RsdMeeting not found', 404);
            }

            $data = $request->input('research_meet');

            $validated = validator($data, [
                'rsdm_rsdtitle' => 'nullable|integer',
                'rsdm_detail' => 'nullable|string',
                'rsdm_title' => 'nullable|string',
                'rsdm_img' => 'nullable|integer|exists:tbimage,image_id',
            ])->validate();

            $RsdMeeting->update($validated);

            return $this->sendResponse($RsdMeeting, 200, 'RsdMeeting updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update RsdMeeting', 500, ['error' => $e->getMessage()]);
        }
    }

}

