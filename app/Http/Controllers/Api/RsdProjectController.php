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
        $projects = RsdProject::with('title')->where('active', 1)->get();
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
            $project = $this->service->create($request->validated());
            return $this->sendResponse($project, 201, 'Project created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create project', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RsdProjectRequest $request, $id)
    {
        $project = RsdProject::find($id);
        if (!$project) return $this->sendError('Not found', 404);

        try {
            $updated = $this->service->update($project, $request->validated());
            return $this->sendResponse($updated, 200, 'Project updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update project', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        $project = RsdProject::find($id);
        if (!$project) return $this->sendError('Not found', 404);

        $project->active = !$project->active;
        $project->save();

        return $this->sendResponse([], 200, 'Project visibility updated');
    }
}

