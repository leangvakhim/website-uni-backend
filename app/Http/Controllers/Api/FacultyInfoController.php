<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\FacultyInfo;
use App\Http\Requests\FacultyInfoRequest;
use Exception;

class FacultyInfoController extends Controller
{
    public function index()
    {
        try {
            $items = FacultyInfo::where('active', 1)->get();
            return $this->sendResponse($items->count() === 1 ? $items->first() : $items);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve faculty info', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $item = FacultyInfo::find($id);
            if (!$item) {
                return $this->sendError('Faculty info not found', 404);
            }
            return $this->sendResponse($item);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve info', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(FacultyInfoRequest $request)
    {
        try {
            $item = FacultyInfo::create($request->validated());
            return $this->sendResponse($item, 201, 'Faculty info created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create info', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(FacultyInfoRequest $request, $id)
    {
        try {
            $item = FacultyInfo::find($id);
            if (!$item) {
                return $this->sendError('Faculty info not found', 404);
            }

            $item->update($request->all());
            return $this->sendResponse($item, 200, 'Faculty info updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update info', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $item = FacultyInfo::find($id);
            if (!$item) {
                return $this->sendError('Faculty info not found', 404);
            }

            $item->active = $item->active == 1 ? 0 : 1;
            $item->save();

            return $this->sendResponse([], 200, 'Faculty info visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
