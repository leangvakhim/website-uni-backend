<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Career;
use App\Http\Requests\CareerRequest;
use Exception;

class CareerController extends Controller
{
    public function index()
    {
        try {
            $careers = Career::where('active', 1)->get();
            return response()->json(['status' => 200, 'data' => $careers]);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $career = Career::find($id);
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
            $career = Career::create($request->validated());
            return response()->json(['status' => 201, 'message' => 'Created', 'data' => $career]);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
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
}
