<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\HeaderSection;
use App\Http\Requests\HeaderSectionRequest;
use App\Services\HeaderSectionService;
use Exception;

class HeaderSectionController extends Controller
{
    protected $service;

    public function __construct(HeaderSectionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = HeaderSection::with('section')->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load data', 500, ['error' => $e->getMessage()]);
        }
    }
    public function show(string $id)
    {
        try {
            $header = HeaderSection::with('section')->find($id);
            if (!$header) {
                return $this->sendError('Header not found', 404);
            }
            return $this->sendResponse($header);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve header', 500, ['error' => $e->getMessage()]);
        }
    }
    

    public function create(HeaderSectionRequest $request)
    {
        try {
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'Created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(HeaderSectionRequest $request, $id)
    {
        try {
            $header = HeaderSection::find($id);
            if (!$header) return $this->sendError('Not found', 404);
            $updated = $this->service->update($header, $request->validated());
            return $this->sendResponse($updated, 200, 'Updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
