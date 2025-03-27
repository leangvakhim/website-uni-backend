<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\FacultyContact;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\FacultyContactRequest;

use Exception;

class FacultyContactController extends Controller
{
    public function index()
    {
        try {
            $items = FacultyContact::where('active', 1)->get();
            return $this->sendResponse($items->count() === 1 ? $items->first() : $items);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve faculty contacts', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $item = FacultyContact::find($id);
            if (!$item) {
                return $this->sendError('Faculty contact not found', 404);
            }
            return $this->sendResponse($item);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve contact', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(FacultyContactRequest $request)
    {
        try {
            $item = FacultyContact::create($request->validated());
            return $this->sendResponse($item, 201, 'Faculty contact created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create contact', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(FacultyContactRequest $request, $id)
    {
        try {
            $item = FacultyContact::find($id);
            if (!$item) {
                return $this->sendError('Faculty contact not found', 404);
            }

            $item->update($request->all());
            return $this->sendResponse($item, 200, 'Faculty contact updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update contact', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $item = FacultyContact::find($id);
            if (!$item) {
                return $this->sendError('Faculty contact not found', 404);
            }

            $item->active = $item->active == 1 ? 0 : 1;
            $item->save();

            return $this->sendResponse([], 200, 'Faculty contact visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
