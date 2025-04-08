<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\FacultyBg;
use App\Services\FacultyBgService;
use App\Http\Requests\FacultyBgRequest;
use Illuminate\Http\Request;
use Exception;

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

    public function create(FacultyBgRequest $request)
    {
        try {
            $data = $request->validated();

            if (!isset($data['fbg_order'])) {
                $data['fbg_order'] = FacultyBg::max('fbg_order') + 1;
            }

            // Use the service to handle nested object creation
            $bgs = app(FacultyBgService::class)->create($data);

            return $this->sendResponse($bgs, 201, 'FacultyBg created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create FacultyBg', 500, ['error' => $e->getMessage()]);
        }
    }



    public function update(Request $request, $id)
    {
        try {
            $info = FacultyBg::find($id);
            if (!$info) return $this->sendError('Faculty Background not found', 404);

            $updated = $this->facultyBgService->update($info, $request->all());
            $updated->load(['faculty', 'img']);

            return $this->sendResponse($updated, 200, 'Faculty Background updated successfully');
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
}
