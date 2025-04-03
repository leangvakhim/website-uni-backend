<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\FacultyInfo;
use App\Services\FacultyInfoService;
use App\Http\Requests\FacultyInfoRequest;
use Illuminate\Http\Request;
use Exception;

class FacultyInfoController extends Controller
{
    protected $facultyInfoService;

    public function __construct(FacultyInfoService $facultyInfoService)
    {
        $this->facultyInfoService = $facultyInfoService;
    }

    public function index()
    {
        try {
            $infos = FacultyInfo::with('faculty')->where('active', 1)->get();
            return $this->sendResponse($infos->count() === 1 ? $infos->first() : $infos);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve faculty infos', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $info = FacultyInfo::with('faculty')->find($id);
            if (!$info) return $this->sendError('Faculty info not found', 404);
            return $this->sendResponse($info);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve faculty info', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(FacultyInfoRequest $request)
    {
        try {
            $created = $this->facultyInfoService->create($request->validated());
            $created->load('faculty');
            return $this->sendResponse($created, 201, 'Faculty info created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create faculty info', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $info = FacultyInfo::find($id);
            if (!$info) return $this->sendError('Faculty info not found', 404);
    
            $updated = $this->facultyInfoService->update($info, $request->all());

            $updated->load('faculty');
    
            return $this->sendResponse($updated, 200, 'Faculty info updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update faculty info', 500, ['error' => $e->getMessage()]);
        }
    }
    

    public function visibility($id)
    {
        try {
            $info = FacultyInfo::find($id);
            if (!$info) return $this->sendError('Faculty info not found', 404);
            $info->active = $info->active ? 0 : 1;
            $info->save();
            return $this->sendResponse([], 200, 'Visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
