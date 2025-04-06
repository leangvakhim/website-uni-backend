<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\YearRequest;
use App\Models\Year;
use App\Services\YearService;
use Exception;

class YearController extends Controller
{
    protected $yearService;

    public function __construct(YearService $yearService)
    {
        $this->yearService = $yearService;
    }

    public function index()
    {
        try {
            $data = Year::with(['studydegree'])->where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch year data', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Year::with(['studydegree'])->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Year not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching year', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(YearRequest $request)
    {
        try {
            $data = $request->validated();
            if (!isset($data['y_order'])) {
                $data['y_order'] = Year::max('y_order') + 1;
            }
            $year = app(YearService::class)->create($data);
            return $this->sendResponse($year, 201, 'Year created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create year', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(YearRequest $request, $id)
    {
        try {
            $year = Year::find($id);
            if (!$year) return $this->sendError('Year not found', 404);

            $updated = $this->yearService->update($year, $request->validated());
            return $this->sendResponse($updated, 200, 'Year updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update year', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $year = Year::find($id);
            if (!$year) return $this->sendError('Year not found', 404);

            $year->active = !$year->active;
            $year->save();
            return $this->sendResponse([], 200, 'Year visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
