<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\SubiddRequest;
use App\Models\Subidd;
use App\Services\SubiddService;
use Exception;
use Illuminate\Http\Request;

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
            $data = Subidd::with('idd')
                ->where('active', 1)
                ->orderBy('sidd_order', 'asc')
                ->get();
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

    // public function create(SubiddRequest $request)
    // {
    //     try {
    //         $data = $request->validated();
    //         if (!isset($data['sidd_order'])) {
    //             $data['sidd_order'] = Subidd::max('sidd_order') + 1;
    //         }
    //         $created = $this->subiddService->create($data);
    //         return $this->sendResponse($created, 201, 'Subidd created');
    //     } catch (Exception $e) {
    //         return $this->sendError('Failed to create', 500, ['error' => $e->getMessage()]);
    //     }
    // }

    // public function update(SubiddRequest $request, $id)
    // {
    //     try {
    //         $subidd = Subidd::find($id);
    //         if (!$subidd) return $this->sendError('Not found', 404);

    //         $updated = $this->subiddService->update($subidd, $request->validated());
    //         return $this->sendResponse($updated, 200, 'Updated successfully');
    //     } catch (Exception $e) {
    //         return $this->sendError('Failed to update', 500, ['error' => $e->getMessage()]);
    //     }
    // }

    public function create(SubiddRequest $request)
    {
        try {
            $validated = $request->validated();
            $subimportants = $validated['subimportant'] ?? [];

            if (empty($subimportants)) {
                return $this->sendError('No important Data Provided', 422);
            }

            $createdsubimportants = [];

            foreach ($subimportants as $item) {
                if (!isset($item['sidd_idd'])) {
                    return $this->sendError('Idd ID is required', 422);
                }

                $item['sidd_order'] = (Subidd::where('sidd_idd', $item['sidd_idd'])->max('sidd_order') ?? 0) + 1;

                $item['sidd_title'] = $item['sidd_title'] ?? null;
                $item['sidd_subtitle'] = $item['sidd_subtitle'] ?? null;
                $item['sidd_tag'] = $item['sidd_tag'] ?? null;
                $item['sidd_date'] = $item['sidd_date'] ?? null;
                $item['display'] = $item['display'] ?? 1;
                $item['active'] = $item['active'] ?? 1;

                $subimportants = Subidd::create($item);
                $createdsubimportants[] = $subimportants;
            }

            return $this->sendResponse($createdsubimportants, 201, 'Subimportant created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Subimportant', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(SubiddRequest $request, $id)
    {
        try {

            $subimportants = Subidd::find($id);
            if (!$subimportants) {
                return $this->sendError('subimportants not found', 404);
            }

            $subimportantData = $request->input('subimportant');
            if (!$subimportantData || !is_array($subimportantData)) {
                return $this->sendError('Invalid subimportant data provided', 422);
            }
            $request->merge($subimportantData);

            $validated = $request->validate([
                'sidd_title' => 'nullable|string',
                'sidd_idd' => 'nullable|integer',
                'sidd_subtitle' => 'nullable|string',
                'sidd_tag' => 'nullable|string',
                'sidd_date' => 'nullable|date',
                'display' => 'nullable|integer',
            ]);

            $subimportants->update($validated);

            return $this->sendResponse($subimportants, 200, 'subimportant updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update subimportant', 500, ['error' => $e->getMessage()]);
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

    public function reorder(Request $request)
    {
        try {
            $data = $request->validate([
                '*.sidd_id' => 'required|integer|exists:tbsubidd,sidd_id',
                '*.sidd_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Subidd::where('sidd_id', $item['sidd_id'])->update([
                    'sidd_order' => $item['sidd_order']
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Subidd order updated successfully',
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to reorder subidd', 500, ['error' => $e->getMessage()]);
        }
    }
}
