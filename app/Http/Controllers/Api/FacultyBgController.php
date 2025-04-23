<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\FacultyBg;
use App\Services\FacultyBgService;
use App\Http\Requests\FacultyBgRequest;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class FacultyBgController extends Controller
{
    protected $facultyBgService;

    public function __construct(FacultyBgService $facultyBgService)
    {
        $this->facultyBgService = $facultyBgService;
    }

    public function index()
    {
        try {
            $bgs = FacultyBg::with(['faculty', 'img'])->where('active', 1)->get();
            return $this->sendResponse($bgs->count() === 1 ? $bgs->first() : $bgs);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve faculty backgrounds', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $bg = FacultyBg::with(['faculty', 'img'])->find($id);
            if (!$bg) return $this->sendError('Faculty background not found', 404);
            return $this->sendResponse($bg);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve background', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'facultyBG' => 'nullable|array',
            'facultyBG.*.fbg_img' => 'nullable|integer|exists:tbimage,image_id',
            'facultyBG.*.fbg_f' => 'nullable|integer|exists:tbfaculty,f_id',
            'facultyBG.*.fbg_name' => 'nullable|string|max:255',
            'facultyBG.*.fbg_order' => 'nullable|integer',
        ]);

        foreach ($request->input('facultyBG', []) as $item) {

            FacultyBG::create([
                'fbg_f' => $item['fbg_f'] ?? null,
                'fbg_order' => $item['fbg_order'] ?? null,
                'fbg_name' => $item['fbg_name'] ?? null,
                'fbg_img' => $item['fbg_img'] ?? null,
                'display' => $item['display'] ?? 0,
                'active' => $item['active'] ?? 1,
            ]);
        }

        return response()->json([
            'status' => 201,
            'status_code' => 'success',
            'message' => 'Faculty BG created successfully'
        ], 201);
    }



    public function update(Request $request, $id)
    {
        try {
            $info = FacultyBg::find($id);
            if (!$info) return $this->sendError('Faculty Background not found', 404);


            try {
                $updated = $this->facultyBgService->update($info, $request->all());
                $updated->load(['faculty', 'img']);
                return $this->sendResponse($updated, 200, 'Faculty Background updated successfully');
            } catch (Exception $e) {
                return $this->sendError('Failed to update Faculty BG', 500, ['error' => $e->getMessage()]);
            }
        } catch (Exception $e) {
            return $this->sendError('Failed to update faculty Background', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $bg = FacultyBg::find($id);
            if (!$bg) return $this->sendError('Faculty background not found', 404);
            $bg->active = $bg->active ? 0 : 1;
            $bg->save();
            return $this->sendResponse([], 200, 'Visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function getByFaculty($f_id)
    {
        $contact = FacultyBg::where('fbg_f', $f_id)
            ->where('active', 1)
            ->orderBy('fbg_order')
            ->get();

        return response()->json(['data' => $contact]);
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            '*.fbg_id' => 'required|integer|exists:tbfaculty_bg,fbg_id', // <-- fix table name
            '*.fbg_order' => 'required|integer'
        ]);


        foreach ($data as $item) {
            FacultyBg::where('fbg_id', $item['fbg_id'])->update(['fbg_order' => $item['fbg_order']]);
        }

        return response()->json([
            'message' => 'fbg order updated successfully',
        ], 200);
    }
}