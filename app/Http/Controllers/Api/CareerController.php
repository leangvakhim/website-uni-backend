<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Career;
use App\Http\Requests\CareerRequest;
use Exception;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        try {
            $careers = Career::with(['img'])->where('active', 1)->get();
            return response()->json(['status' => 200, 'data' => $careers]);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $career = Career::with(['img'])->find($id);
            return $career
                ? response()->json(['status' => 200, 'data' => $career])
                : response()->json(['status' => 404, 'message' => 'Not Found']);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function create(CareerRequest $request)
    {
        try {
            $data = $request->validated();

            if (!isset($data['c_order'])) {
                $data['c_order'] = Career::max('c_order') + 1;
            }

            $event = Career::create($data);
            return $this->sendResponse($event, 201, 'Career created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create career', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(CareerRequest $request, $id)
    {
        try {
            $career = Career::find($id);
            if (!$career) return response()->json(['status' => 404, 'message' => 'Not Found']);
            $career->update($request->validated());
            return response()->json(['status' => 200, 'message' => 'Updated', 'data' => $career]);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        $career = Career::find($id);
        if (!$career) return response()->json(['status' => 404, 'message' => 'Not Found']);
        $career->active = $career->active ? 0 : 1;
        $career->save();
        return response()->json(['status' => 200, 'message' => 'Visibility toggled']);
    }

    public function duplicate($id)
    {
        $career = Career::find($id);

        if (!$career) {
            return response()->json(['message' => 'Career not found'], 404);
        }

        $newCareer = $career->replicate();
        $newCareer->c_title = $career->c_title . ' (Copy)';
        $newCareer->c_order = Career::max('c_order') + 1;
        $newCareer->save();

        return response()->json(['message' => 'Career duplicated', 'data' => $newCareer], 200);
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            '*.c_id' => 'required|integer|exists:tbcareer,c_id',
            '*.c_order' => 'required|integer'
        ]);

        foreach ($data as $item) {
            Career::where('c_id', $item['c_id'])->update(['c_order' => $item['c_order']]);
        }

        return response()->json([
            'message' => 'Career order updated successfully',
        ], 200);
    }
}
