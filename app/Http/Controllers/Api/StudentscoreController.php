<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Studentscore;
use App\Models\Student;
use App\Models\Subject;
use App\Http\Requests\StudentscoreRequest;
use Illuminate\Http\Request;
use Exception;

class StudentscoreController extends Controller
{
    public function index()
    {
        try {
            $scores = Studentscore::where('active', 1)->get();
            return $this->sendResponse($scores->count() === 1 ? $scores->first() : $scores);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch scores', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $score = Studentscore::find($id);
            return $score ? $this->sendResponse($score) : $this->sendError('Score not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch score', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(StudentScoreRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdScores = [];
    
            if (!isset($validated['student_id']) || !isset($validated['subject_id'])) {
                return $this->sendError('Student ID and Subject ID are required', 422);
            }
    
            $student = Student::find($validated['student_id']);
            $subject = Subject::find($validated['subject_id']);
    
            if (!$student || !$subject) {
                return $this->sendError('Student or Subject not found', 404);
            }
    
            if (isset($validated['scores']) && is_array($validated['scores'])) {
                foreach ($validated['scores'] as $scoreItem) {
                    $scoreItem['student_id'] = $student->student_id;
                    $scoreItem['subject_id'] = $subject->subject_id;
    
                    $scoreItem['display'] = $scoreItem['display'] ?? 1;
                    $scoreItem['active'] = $scoreItem['active'] ?? 1;
    
                    $createdScores[] = StudentScore::create($scoreItem);
                }
            }
    
            return $this->sendResponse($createdScores, 201, 'Multiple scores created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create scores', 500, ['error' => $e->getMessage()]);
        }
    }
    

    public function update(StudentScoreRequest $request, $id)
    {
        try {
            $validated = $request->validated(); // assuming you're using StudentscoreRequest
            $updatedScores = [];
    
            if ($request->has('scores') && is_array($validated['scores'])) {
                // MULTIPLE SCORES
                foreach ($validated['scores'] as $item) {
                    $score = Studentscore::find($id);
                    if (!$score) return $this->sendError('Score not found', 404);
    
                    $item['student_id'] = $validated['student_id'];
                    $item['subject_id'] = $validated['subject_id'];
                    $item['score'] = $item['score'] ?? null;
                    $item['display'] = $item['display'] ?? 0;
                    $item['active'] = $item['active'] ?? 1;
    
                    $score->update($item);
                    $updatedScores[] = $score;
                }
    
                return $this->sendResponse($updatedScores, 200, 'Multiple scores updated successfully');
            } else {
                // SINGLE SCORE
                $score = Studentscore::find($id);
                if (!$score) return $this->sendError('Score not found', 404);
    
                $updateData = [
                    'student_id' => $validated['student_id'],
                    'subject_id' => $validated['subject_id'],
                    'score' => $validated['score'] ?? null,
                    'display' => $validated['display'] ?? 0,
                    'active' => $validated['active'] ?? 1,
                ];
    
                $score->update($updateData);
    
                return $this->sendResponse($score, 200, 'Score updated successfully');
            }
        } catch (Exception $e) {
            return $this->sendError('Failed to update score(s)', 500, ['error' => $e->getMessage()]);
        }
    }
    
    

    public function visibility($id)
    {
        try {
            $score = Studentscore::find($id);
            if (!$score) return $this->sendError('Score not found', 404);

            $score->active = !$score->active;
            $score->save();
            return $this->sendResponse([], 200, 'Visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
