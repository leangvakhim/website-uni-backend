<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\RsdTitle;
use App\Http\Requests\RsdTitleRequest;
use Exception;

class RsdTitleController extends Controller
{
    public function index()
    {
        try {
            $data = RsdTitle::where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve records', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = RsdTitle::find($id);
            if (!$data) {
                return $this->sendError('Record not found', 404);
            }
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(RsdTitleRequest $request)
    {
        try {
            $data = $request->validated();

            if (!isset($data['rsdt_order'])) {
                $data['rsdt_order'] = RsdTitle::max('rsdt_order') + 1;
            }

            $event = RsdTitle::create($data);
            return $this->sendResponse($event, 201, 'Rsdt created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Rsdt', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RsdTitleRequest $request, $id)
    {
        try {
            $rsd = RsdTitle::find($id);
            if (!$rsd) {
                return $this->sendError('Record not found', 404);
            }
            $rsd->update($request->validated());
            return $this->sendResponse($rsd, 200, 'Record updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $rsd = RsdTitle::find($id);
            if (!$rsd) {
                return $this->sendError('Record not found', 404);
            }
            $rsd->active = $rsd->active == 1 ? 0 : 1;
            $rsd->save();
            return $this->sendResponse([], 200, 'Visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
