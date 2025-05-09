<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\FacultyInfo;
use App\Services\FacultyInfoService;
use App\Http\Requests\FacultyInfoRequest;
use App\Models\Faculty;
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
            $data = $request->validated();
            $createInfo = [];

            if(!isset($data['f_id'])){
                return $this->sendError('Faculty ID is required', 422);
            }

            $faculty = Faculty::find($data['f_id']);
            if(!$faculty){
                return $this->sendError('Faculty not found', 404);
            }


            if (isset($data['finfo_f']) && is_array($data['finfo_f'])) {
                foreach ($data['finfo_f'] as $item) {
                    $item['finfo_f'] = $faculty->f_id;

                    if (!isset($item['finfo_order'])) {
                        $item['finfo_order'] = (FacultyInfo::where('finfo_f', $faculty->f_id)->max('finfo_order') ?? 0) +1;
                    }


                    $item['active'] = $item['active'] ?? 1;
                    $item['display'] = $item['display'] ?? 1;

                    $createInfo [] = FacultyInfo::create($item);
                }
            }
            return $this->sendResponse($createInfo, 201, 'FacultyInfo created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create FacultyInfo', 500, ['error' => $e->getMessage()]);
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

    public function getByFaculty($f_id)
    {
        $contact = FacultyInfo::where('finfo_f', $f_id)
            ->where('active', 1)
            ->orderBy('finfo_order')
            ->get();

        return response()->json(['data' => $contact]);
    }


    public function reorder(Request $request)
    {
        $data = $request->validate([
            '*.finfo_id' => 'required|integer|exists:tbfaculty_info,finfo_id',
            '*.finfo_order' => 'required|integer'
        ]);

        foreach ($data as $item) {
            FacultyInfo::where('finfo_id', $item['finfo_id'])->update(['finfo_order' => $item['finfo_order']]);
        }

        return response()->json([
            'message' => 'Faculty contact order updated successfully',
        ], 200);
    }

}