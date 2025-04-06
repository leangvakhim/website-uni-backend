<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\SubiddRequest;
use App\Models\Subidd;
use App\Services\SubiddService;
use Exception;

class SubiddController extends Controller
{
    protected $subiddService;

    public function __construct(SubiddService $subiddService)
    {
        $this->subiddService = $subiddService;
    }

    public function index()
    {
        try {
            $data = Subidd::with('idd')->where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch Subidd', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $data = Subidd::with('idd')->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching Subidd', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(SubiddRequest $request)
    {
        try {
            $data = $request->validated();
            if (!isset($data['sidd_order'])) {
                $data['sidd_order'] = Subidd::max('sidd_order') + 1;
            }
            $created = $this->subiddService->create($data);
            return $this->sendResponse($created, 201, 'Subidd created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(SubiddRequest $request, $id)
    {
        try {
            $subidd = Subidd::find($id);
            if (!$subidd) return $this->sendError('Not found', 404);

            $updated = $this->subiddService->update($subidd, $request->validated());
            return $this->sendResponse($updated, 200, 'Updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $subidd = Subidd::find($id);
            if (!$subidd) return $this->sendError('Not found', 404);

            $subidd->active = !$subidd->active;
            $subidd->save();
            return $this->sendResponse([], 200, 'Visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
