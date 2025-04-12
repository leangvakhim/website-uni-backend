<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Btnss;
use App\Http\Requests\BtnssRequest;
use Exception;

class BtnssController extends Controller
{
    public function index()
    {
        try {
            $texts = Btnss::all();
            return $this->sendResponse($texts);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve Btnss', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $btn = Btnss::find($id);
            if (!$btn) return $this->sendError('Record not found', 404);
            return $this->sendResponse($btn);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(BtnssRequest $request)
    {
        try {
            $btn = Btnss::create($request->validated());
            return $this->sendResponse($btn, 201, 'Created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(BtnssRequest $request, $id)
    {
        try {
            $btn = Btnss::find($id);
            if (!$btn) return $this->sendError('Record not found', 404);
            $btn->update($request->validated());
            return $this->sendResponse($btn, 200, 'Updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update record', 500, ['error' => $e->getMessage()]);
        }
    }
}
