<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\FacultyBg;
use App\Services\FacultyBgService;
use App\Http\Requests\FacultyBgRequest;
use App\Models\Faculty;
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
            $createdBgs = [];
    
            if(!isset($data['f_id'])) {
                return $this->sendError('Faculty ID (fbg_f) is required', 422);
            }
            
            $faculty = Faculty::find($data['f_id']);
            if (!$faculty) {
                return $this->sendError('Faculty not found', 404);
            }
            if (isset($data['fbg_f']) && is_array($data['fbg_f'])) {
                foreach ($data['fbg_f'] as $item) {
                    $item['fbg_f'] = $faculty->f_id;
                    
                    if (isset($item['fbg_order'])) {
                        $item['fbg_order'] = (FacultyBg::where('fbg_f', $faculty->f_id)->max('fbg_order') ?? 0) +1;
                    }
                    
                    $item['fbg_img'] = $item['fbg_img'] ?? $data['fbg_img'];
                    $item['active'] = $item['active'] ?? 1;
                    $item['display'] = $item['display'] ?? 1;
                    
                    $createdBgs [] = FacultyBg::create($item);
                }
            }
            return $this->sendResponse($createdBgs, 201, 'Faculty Background created successfully');
            
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