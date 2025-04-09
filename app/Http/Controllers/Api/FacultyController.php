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
            ])
            ->where('active', 1)
            ->orderBy('f_order', 'asc')
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
            $data = $request->validated();

            if (!isset($data['f_order'])) {
                $data['f_order'] = Faculty::max('f_order') + 1;
            }

            $faculty = Faculty::create($data);

            return $this->sendResponse($faculty, 201, 'Faculty created');
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
    public function duplicate($id)
    {
        $faculty = Faculty::find($id);

        if (!$faculty) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $newFaculty = $faculty->replicate();
        $newFaculty->f_name = $faculty->f_name . ' (Copy)';
        $newFaculty->f_order = Faculty::max('f_order') + 1;
        $newFaculty->save();

        return response()->json(['message' => 'Faculty duplicated', 'data' => $newFaculty], 200);
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            '*.f_id' => 'required|integer|exists:tbfaculty,f_id',
            '*.f_order' => 'required|integer'
        ]);

        foreach ($data as $item) {
            Faculty::where('f_id', $item['f_id'])->update(['f_order' => $item['f_order']]);
        }

        return response()->json([
            'message' => 'Faculty order updated successfully',
        ], 200);
    }
}
