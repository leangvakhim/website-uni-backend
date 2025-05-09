<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Scholarship;
use App\Http\Requests\ScholarshipRequest;
use Illuminate\Http\Request;
use Exception;

class ScholarshipController extends Controller
{
    public function index()
    {
        try {
            $scholarships = Scholarship::with(['image', 'letter'])
                ->where('active', 1)
                ->get();

            return $this->sendResponse(
                $scholarships->count() === 1 ? $scholarships->first() : $scholarships
            );
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve scholarships', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $scholarship = Scholarship::with(['image', 'letter'])->find($id);

            if (!$scholarship) {
                return $this->sendError('Scholarship not found', 404);
            }

            return $this->sendResponse($scholarship);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve scholarship', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(ScholarshipRequest $request)
    {
        try {
            $data = $request->validated();

            $data['ref_id'] = $data['ref_id'] ?? (Scholarship::max('ref_id') ? Scholarship::max('ref_id') + 1 : 100);

            if (!isset($data['sc_orders'])) {
                $data['sc_orders'] = Scholarship::max('sc_orders') + 1;
            }

            $Scholarship = Scholarship::create($data);
            return $this->sendResponse($Scholarship, 201, 'Scholarship created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Scholarship', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(ScholarshipRequest $request, $id)
    {
        try {
            $scholarship = Scholarship::find($id);
            if (!$scholarship) {
                return $this->sendError('Scholarship not found', 404);
            }

            if (!$scholarship->ref_id && $request->has('ref_id')) {
                $scholarship->ref_id = $request->input('ref_id');
                $scholarship->save();
            }

            $scholarship->update($request->validated());
            return $this->sendResponse($scholarship, 200, 'Scholarship updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update scholarship', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $scholarship = Scholarship::find($id);
            if (!$scholarship) {
                return $this->sendError('Scholarship not found', 404);
            }

            $scholarship->active = $scholarship->active == 1 ? 0 : 1;
            $scholarship->save();

            return $this->sendResponse([], 200, 'Scholarship visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function duplicate($id)
    {
        try {
            $scholarship = Scholarship::find($id);

            if (!$scholarship) {
                return $this->sendError('Scholarship not found', 404);
            }

            $newScholarship = $scholarship->replicate();
            $newScholarship->sc_title = $scholarship->sc_title . ' (Copy)';
            $newScholarship->sc_orders = Scholarship::max('sc_orders') + 1;
            $newScholarship->save();

            return $this->sendResponse($newScholarship, 200, 'Scholarship duplicated');
        } catch (Exception $e) {
            return $this->sendError('Failed to duplicate scholarship', 500, ['error' => $e->getMessage()]);
        }
    }

    public function reorder(Request $request)
    {
        try {
            $data = $request->validate([
                '*.sc_id' => 'required|integer|exists:scholarships,sc_id',
                '*.sc_orders' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Scholarship::where('sc_id', $item['sc_id'])->update(['sc_orders' => $item['sc_orders']]);
            }

            return response()->json([
                'message' => 'Scholarship order updated successfully',
            ], 200);
        } catch (Exception $e) {
            return $this->sendError('Failed to update scholarship order', 500, ['error' => $e->getMessage()]);
        }
    }

    public function assignRefIds()
    {
        try {
            $scholarships = Scholarship::whereNull('ref_id')->get();
            $nextRef = Scholarship::max('ref_id') ?? 99;

            foreach ($scholarships as $scholarship) {
                $scholarship->ref_id = ++$nextRef;
                $scholarship->save();
            }

            return response()->json(['message' => 'Ref IDs assigned successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to assign Ref IDs', 'error' => $e->getMessage()], 500);
        }
    }

}
