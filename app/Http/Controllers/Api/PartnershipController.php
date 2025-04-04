<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Partnership;
use App\Http\Requests\PartnershipRequest;
use Exception;

class PartnershipController extends Controller
{
    public function index()
    {
        try {
            $data = Partnership::where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch partnerships', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $item = Partnership::find($id);
            if (!$item) return $this->sendError('Partnership not found', 404);
            return $this->sendResponse($item);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch partnership', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(PartnershipRequest $request)
    {
        try {
            $data = $request->validated();

            if (!isset($data['ps_order'])) {
                $data['ps_order'] = Partnership::max('ps_order') + 1;
            }

            $item = Partnership::create($data);
            return $this->sendResponse($item, 201, 'Partnership created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create partnership', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(PartnershipRequest $request, $id)
    {
        try {
            $item = Partnership::find($id);
            if (!$item) return $this->sendError('Partnership not found', 404);

            $item->update($request->validated());
            return $this->sendResponse($item, 200, 'Partnership updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update partnership', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $item = Partnership::find($id);
            if (!$item) return $this->sendError('Partnership not found', 404);

            $item->active = $item->active ? 0 : 1;
            $item->save();
            return $this->sendResponse([], 200, 'Visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
