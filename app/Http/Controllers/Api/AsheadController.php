<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Ashead;
use App\Http\Requests\AsheadRequest;
use Exception;

class AsheadController extends Controller
{
    public function index()
    {
        try {
            $headers = Ashead::all();
            return $this->sendResponse($headers);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve Ashead records', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $header = Ashead::find($id);
            if (!$header) return $this->sendError('Record not found', 404);
            return $this->sendResponse($header);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(AsheadRequest $request)
    {
        try {
            $header = Ashead::create($request->validated());
            return $this->sendResponse($header, 201, 'Created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Ashead record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(AsheadRequest $request, $id)
    {
        try {
            $header = Ashead::find($id);
            if (!$header) return $this->sendError('Record not found', 404);
            $header->update($request->validated());
            return $this->sendResponse($header, 200, 'Updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Ashead record', 500, ['error' => $e->getMessage()]);
        }
    }
}
