<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Subcontact;
use App\Http\Requests\SubcontactRequest;
use Exception;
use Illuminate\Http\Request;

class SubcontactController extends Controller
{
    public function index()
    {
        try {
            $subhas = Subcontact::with(['image'])->where('active', 1)->get();
            return $this->sendResponse($subhas->count() === 1 ? $subhas->first() : $subhas);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve Subcontact', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Subcontact::with('image')->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Subcontact not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error retrieving Subcontact', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(SubcontactRequest $request)
    {
        try {
            $data = Subcontact::create($request->validated());
            return $this->sendResponse($data, 201, 'Subcontact created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Subcontact', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(SubcontactRequest $request, $id)
    {
        try {
            $sub = Subcontact::find($id);
            if (!$sub) return $this->sendError('Not found', 404);
            $sub->update($request->validated());
            return $this->sendResponse($sub, 200, 'Updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Subcontact', 500, ['error' => $e->getMessage()]);
        }
    }
    public function visibility($id)
    {
        try {
            $subha = Subcontact::find($id);
            if (!$subha) return $this->sendError('Subcontact not found', 404);
            $subha->active = $subha->active ? 0 : 1;
            $subha->save();
            return $this->sendResponse([], 200, 'Visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Subcontact to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function reorder(Request $request)
    {
        try {
            $data = $request->validate([
                '*.scon_id' => 'required|integer|exists:tbsubcontact,scon_id',
                '*.scon_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Subcontact::where('scon_id', $item['scon_id'])->update([
                    'scon_order' => $item['scon_order']
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Subcontact order updated successfully',
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to reorder Subcontact', 500, ['error' => $e->getMessage()]);
        }
    }
}
