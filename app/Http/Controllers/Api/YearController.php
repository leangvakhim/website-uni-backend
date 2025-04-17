<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\YearRequest;
use App\Models\Year;
use App\Services\YearService;
use Illuminate\Http\Request;
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
            $data = Year::with('studydegree')
            ->where('active', 1)
            ->orderBy('y_order', 'asc')
            ->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch Year data', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Year::with('studydegree')->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Year not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching Year', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(YearRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdYear = [];

            if (isset($validated['year']) && is_array($validated['year'])) {
                foreach ($validated['year'] as $item) {

                    $item['y_order'] = (Year::where('y_std', $item['y_std'])->max('y_order') ?? 0) + 1;

                    $item['y_std'] = $item['y_std'] ?? null;
                    $item['y_title'] = $item['y_title'] ?? null;
                    $item['y_subtitle'] = $item['y_subtitle'] ?? null;
                    $item['y_detail'] = $item['y_detail'] ?? null;
                    $item['display'] = $item['display'] ?? 1;
                    $item['active'] = $item['active'] ?? 1;

                    $createdYear[] = Year::create($item);
                }
            }

            return $this->sendResponse($createdYear, 201, 'Year records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Year', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(YearRequest $request, $id)
    {
        try {
            $year = Year::find($id);
            if (!$year) {
                return $this->sendError('Year not found', 404);
            }

            $request->merge($request->input('year'));

            $validated = $request->validate([
                'y_title' => 'required|string',
                'y_subtitle' => 'nullable|string',
                'y_detail' => 'nullable|string',
                'y_std' => 'nullable|integer',
                'display' => 'nullable|integer',
            ]);

            $year->update($validated);

            return $this->sendResponse($year, 200, 'year updated successfully');
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

    public function reorder(Request $request)
    {
        try {
            $data = $request->validate([
                '*.y_id' => 'required|integer|exists:tbyear,y_id',
                '*.y_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Year::where('y_id', $item['y_id'])->update([
                    'y_order' => $item['y_order']
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Year order updated successfully',
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to reorder year', 500, ['error' => $e->getMessage()]);
        }
    }
}
