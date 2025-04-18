<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Setting2;
use App\Http\Requests\Setting2Request;
use Exception;
use Illuminate\Http\Request;

class Setting2Controller extends Controller
{
    public function index()
    {
        try {
            $items = Setting2::all(); 
            return $this->sendResponse($items->count() === 1 ? $items->first() : $items);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch records', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $item = Setting2::find($id);
            return $item ? $this->sendResponse($item) : $this->sendError('Record not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(Setting2Request $request)
    {
        try {
            $data = $request->validated();
            $item = Setting2::create($data);
            return $this->sendResponse($item, 201, 'Record created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(Setting2Request $request, $id)
    {
        try {
            $item = Setting2::find($id);
            if (!$item) return $this->sendError('Record not found', 404);
            $item->update($request->validated());
            return $this->sendResponse($item, 200, 'Record updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function duplicate($id)
    {
        try {
            $item = Setting2::find($id);
            if (!$item) return $this->sendError('Record not found', 404);

            $copy = $item->replicate();
            $copy->set_facultytitle = $copy->set_facultytitle . ' (Copy)';
            $copy->save();

            return $this->sendResponse($copy, 201, 'Record duplicated');
        } catch (Exception $e) {
            return $this->sendError('Failed to duplicate record', 500, ['error' => $e->getMessage()]);
        }
    }
}
