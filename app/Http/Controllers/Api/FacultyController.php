<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Services\FacultyService;
use App\Http\Requests\FacultyRequest;
use Exception;

class FacultyController extends Controller
{
    protected $facultyService;

    public function __construct(FacultyService $facultyService)
    {
        $this->facultyService = $facultyService;
    }

    public function index()
    {
        try {
            $faculties = Faculty::with([
                'img:image_id,img',
                'social:social_id,social_img,social_order,display,active',
                'contact:fc_id,fc_name',
                'info:finfo_id,finfo_title,finfo_detail,finfo_side',
                'bg:fbg_id,fbg_name,fbg_img'
            ])
            ->where('active', 1)
            ->get();

            return $this->sendResponse(
                $faculties->count() === 1 ? $faculties->first() : $faculties
            );
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve faculties', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $faculty = Faculty::with([
                'img:image_id,img',
                'social:social_id,social_img,social_order,display,active',
                'contact:fc_id,fc_name',
                'info:finfo_id,finfo_title,finfo_detail,finfo_side',
                'bg:fbg_id,fbg_name,fbg_img'
            ])->find($id);

            if (!$faculty) {
                return $this->sendError('Faculty not found', 404);
            }
            return $this->sendResponse($faculty);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve faculty', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(FacultyRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $faculty = $this->facultyService->createFaculty($validatedData);
            return $this->sendResponse($faculty, 201, 'Faculty created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create faculty', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $faculty = Faculty::find($id);
            if (!$faculty) {
                return $this->sendError('Faculty not found', 404);
            }

            $updated = $this->facultyService->updateFaculty($faculty, $request->all());
            return $this->sendResponse($updated, 200, 'Faculty updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update faculty', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $faculty = Faculty::find($id);
            if (!$faculty) {
                return $this->sendError('Faculty not found', 404);
            }

            $faculty->active = $faculty->active == 1 ? 0 : 1;
            $faculty->save();

            return $this->sendResponse([], 200, 'Faculty visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
