<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Year;
use App\Http\Requests\YearRequest;
use Exception;

class YearController extends Controller
{
    public function index()
    {
        try {
            $data = Year::where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve records', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Year::find($id);
            if (!$data) return $this->sendError('Record not found', 404);
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(YearRequest $request)
    {
        try {
            $data = Year::create($request->validated());
            return $this->sendResponse($data, 201, 'Record created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(YearRequest $request, $id)
    {
        try {
            $data = Year::find($id);
            if (!$data) return $this->sendError('Record not found', 404);
            $data->update($request->validated());
            return $this->sendResponse($data, 200, 'Record updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $data = Year::find($id);
            if (!$data) return $this->sendError('Record not found', 404);
            $data->active = !$data->active;
            $data->save();
            return $this->sendResponse([], 200, 'Visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
