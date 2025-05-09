<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\RsdProject;
use App\Services\RsdProjectService;
use App\Http\Requests\RsdProjectRequest;
use Exception;

class RsdProjectController extends Controller
{
    protected $service;

    public function __construct(RsdProjectService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $projects = RsdProject::with('title')->get();
        return $this->sendResponse($projects);
    }

    public function show($id)
    {
        $project = RsdProject::with('title')->find($id);
        return $project ? $this->sendResponse($project) : $this->sendError('Not found', 404);
    }

    public function create(RsdProjectRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdRsdDesc = [];

            if (isset($validated['research_project']) && is_array($validated['research_project'])) {
                foreach ($validated['research_project'] as $item) {
                    $item['rsdp_rsdtile'] = $item['rsdp_rsdtile'] ?? null;
                    $item['rsdp_detail'] = $item['rsdp_detail'] ?? null;
                    $item['rsdp_title'] = $item['rsdp_title'] ?? null;

                    if (!empty($item['rsdp_id'])) {
                        // Update existing
                        $existing = RsdProject::find($item['rsdp_id']);
                        if ($existing) {
                            $existing->update([
                                'rsdp_title' => $item['rsdp_title'],
                                'rsdp_detail' => $item['rsdp_detail'],
                                'rsdp_rsdtile' => $item['rsdp_rsdtile'],
                            ]);
                            $createdRsdProject[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = RsdProject::where('rsdp_title', $item['rsdp_title'])
                            ->where('rsdp_title', $item['rsdp_title'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = RsdProject::create($item);
                            $createdRsdProject[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdRsdProject, 201, 'RsdProject records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update RsdProject', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RsdProjectRequest $request, $id)
    {
        try {
            $RsdProject = RsdProject::find($id);
            if (!$RsdProject) {
                return $this->sendError('RsdProject not found', 404);
            }

            $data = $request->input('research_project');

            $validated = validator($data, [
                'rsdp_title' => 'nullable|string|max:255',
                'rsdp_detail' => 'nullable|string',
                'rsdp_rsdtile' => 'nullable|integer',
            ])->validate();

            $RsdProject->update($validated);

            return $this->sendResponse($RsdProject, 200, 'RsdProject updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update RsdProject', 500, ['error' => $e->getMessage()]);
        }
    }
}

