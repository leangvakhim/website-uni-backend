<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Rason;
use App\Http\Requests\RasonRequest;
use Exception;

class RasonController extends Controller
{
    public function index()
    {
        try {
            $texts =Rason::all();
            return $this->sendResponse($texts);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve texts', 500, $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $data = Rason::find($id);
            if (!$data) return $this->sendError('Record not found', 404);
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(RasonRequest $request)
    {
        try {
            $data = Rason::create($request->validated());
            return $this->sendResponse($data, 201, 'Record created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RasonRequest $request, $id)
    {
        try {
            $data = Rason::find($id);
            if (!$data) return $this->sendError('Record not found', 404);
            $data->update($request->validated());
            return $this->sendResponse($data, 200, 'Record updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update record', 500, ['error' => $e->getMessage()]);
        }
    }
}
