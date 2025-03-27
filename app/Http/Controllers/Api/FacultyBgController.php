<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\FacultyBg;
use App\Http\Requests\FacultyBgRequest;
use Exception;

class FacultyBgController extends Controller
{
    public function index()
    {
        try {
            $items = FacultyBg::with('img:image_id,img')->where('active', 1)->get();
            return $this->sendResponse($items->count() === 1 ? $items->first() : $items);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve faculty backgrounds', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $item = FacultyBg::with('img:image_id,img')->find($id);
            if (!$item) {
                return $this->sendError('Faculty background not found', 404);
            }
            return $this->sendResponse($item);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve background', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(FacultyBgRequest $request)
    {
        try {
            $item = FacultyBg::create($request->validated());
            return $this->sendResponse($item, 201, 'Faculty background created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create background', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(FacultyBgRequest $request, $id)
    {
        try {
            $item = FacultyBg::find($id);
            if (!$item) {
                return $this->sendError('Faculty background not found', 404);
            }

            $item->update($request->all());
            return $this->sendResponse($item, 200, 'Faculty background updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update background', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $item = FacultyBg::find($id);
            if (!$item) {
                return $this->sendError('Faculty background not found', 404);
            }

            $item->active = $item->active == 1 ? 0 : 1;
            $item->save();

            return $this->sendResponse([], 200, 'Faculty background visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
