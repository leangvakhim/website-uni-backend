<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Rsdl;
use App\Http\Requests\RsdlRequest;
use Exception;

class RsdlController extends Controller
{
    public function index()
    {
        try {
            $rsdls = Rsdl::where('active', 1)->get();
            return response()->json(['status' => 200, 'data' => $rsdls]);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $rsdl = Rsdl::find($id);
            return $rsdl
                ? response()->json(['status' => 200, 'data' => $rsdl])
                : response()->json(['status' => 404, 'message' => 'Not Found']);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function create(RsdlRequest $request)
    {
        try {
            $rsdl = Rsdl::create($request->validated());
            return response()->json(['status' => 201, 'message' => 'Created', 'data' => $rsdl]);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function update(RsdlRequest $request, $id)
    {
        try {
            $rsdl = Rsdl::find($id);
            if (!$rsdl) return response()->json(['status' => 404, 'message' => 'Not Found']);
            $rsdl->update($request->validated());
            return response()->json(['status' => 200, 'message' => 'Updated', 'data' => $rsdl]);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        $rsdl = Rsdl::find($id);
        if (!$rsdl) return response()->json(['status' => 404, 'message' => 'Not Found']);
        $rsdl->active = $rsdl->active ? 0 : 1;
        $rsdl->save();
        return response()->json(['status' => 200, 'message' => 'Visibility toggled']);
    }
}
