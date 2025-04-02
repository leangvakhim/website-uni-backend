<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\RsdDesc;
use App\Services\RsdDescService;
use App\Http\Requests\RsdDescRequest;
use Exception;

class RsdDescController extends Controller
{
    protected $service;

    public function __construct(RsdDescService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = RsdDesc::with('title')->where('active', 1)->get();
        return $this->sendResponse($data);
    }

    public function show($id)
    {
        $desc = RsdDesc::with('title')->find($id);
        return $desc ? $this->sendResponse($desc) : $this->sendError('Not found', 404);
    }

    public function create(RsdDescRequest $request)
    {
        try {
            $desc = $this->service->create($request->validated());
            return $this->sendResponse($desc, 201, 'Created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RsdDescRequest $request, $id)
    {
        $desc = RsdDesc::find($id);
        if (!$desc) return $this->sendError('Not found', 404);

        try {
            $updated = $this->service->update($desc, $request->validated());
            return $this->sendResponse($updated, 200, 'Updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        $desc = RsdDesc::find($id);
        if (!$desc) return $this->sendError('Not found', 404);

        $desc->active = !$desc->active;
        $desc->save();

        return $this->sendResponse([], 200, 'Visibility toggled');
    }
}
