<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Student;
use App\Http\Requests\StudentRequest;
use Illuminate\Http\Request;
use Exception;

class StudentController extends Controller
{
    public function index()
    {
        try {
            $students = Student::where('active', 1)->get();
            return $this->sendResponse($students->count() === 1 ? $students->first() : $students);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch students', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $student = Student::find($id);
            return $student ? $this->sendResponse($student) : $this->sendError('Student not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch student', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(StudentRequest $request)
    {
        try {
            $data = $request->validated();
            $student = Student::create($data);
            return $this->sendResponse($student, 201, 'Student created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create student', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(StudentRequest $request, $id)
    {
        try {
            $student = Student::find($id);
            if (!$student) return $this->sendError('Student not found', 404);
            $student->update($request->all());
            return $this->sendResponse($student, 200, 'Student updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update student', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $student = Student::find($id);
            if (!$student) return $this->sendError('Student not found', 404);
            $student->active = !$student->active;
            $student->save();
            return $this->sendResponse([], 200, 'Visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
