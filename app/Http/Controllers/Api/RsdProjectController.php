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
            $createdRsdProject = [];

            if (isset($validated['research_project']) && is_array($validated['research_project'])) {
                foreach ($validated['research_project'] as $item) {

                    $item['rsdp_rsdtitle'] = $item['rsdp_rsdtitle'] ?? null;
                    $item['rsdp_detail'] = $item['rsdp_detail'] ?? null;

                    $createdRsdProject[] = RsdProject::create($item);
                }
            }

            return $this->sendResponse($createdRsdProject, 201, 'RsdProject records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create RsdProject', 500, ['error' => $e->getMessage()]);
        }
    }
    public function update(RsdProjectRequest $request, $id)
    {
        try {
            $rsdproject = RsdProject::find($id);
            if (!$rsdproject) {
                return $this->sendError('rsdproject not found', 404);
            }

            $request->merge($request->input('research_project'));

            $validated = $request->validate([
                'rsdp_rsdtitle' => 'nullable|integer|exists:tbrsd_title,rsdt_id',
                'rsdp_detail' => 'nullable|string',
            ]);

            $rsdproject->update($validated);

            return $this->sendResponse($rsdproject, 200, 'rsdproject updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update rsdproject', 500, ['error' => $e->getMessage()]);
        }
    }

}

