<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Subject;
use App\Http\Requests\SubjectRequest;
use Illuminate\Http\Request;
use Exception;

class SubjectController extends Controller
{
    public function index()
    {
        try {
            $subjects = Subject::where('active', 1)->get();
            return $this->sendResponse($subjects->count() === 1 ? $subjects->first() : $subjects);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch subjects', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $subject = Subject::find($id);
            return $subject ? $this->sendResponse($subject) : $this->sendError('Subject not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch subject', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(SubjectRequest $request)
    {
        try {
            $data = $request->validated();
            $subject = Subject::create($data);
            return $this->sendResponse($subject, 201, 'Subject created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create subject', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(SubjectRequest $request, $id)
    {
        try {
            $subject = Subject::find($id);
            if (!$subject) return $this->sendError('Subject not found', 404);

            $subject->update($request->all());
            return $this->sendResponse($subject, 200, 'Subject updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update subject', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $subject = Subject::find($id);
            if (!$subject) return $this->sendError('Subject not found', 404);

            $subject->active = !$subject->active;
            $subject->save();
            return $this->sendResponse([], 200, 'Visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
