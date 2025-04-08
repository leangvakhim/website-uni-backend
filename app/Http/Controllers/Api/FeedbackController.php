<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Feedback;
use App\Http\Requests\FeedbackRequest;
use App\Services\FeedbackService;
use Exception;

class FeedbackController extends Controller
{
    protected $service;

    public function __construct(FeedbackService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $feedbacks = Feedback::with(['section', 'image'])
                ->where('active', 1)
                ->get();
            return response()->json(['status' => 200, 'data' => $feedbacks]);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $feedback = Feedback::with(['section', 'image'])->find($id);
            return $feedback
                ? response()->json(['status' => 200, 'data' => $feedback])
                : response()->json(['status' => 404, 'message' => 'Not Found']);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function create(FeedbackRequest $request)
    {
        try {
            $data = $request->validated();

            if (!isset($data['fb_order'])) {
                $data['fb_order'] = Feedback::max('fb_order') + 1;
            }

            $feedback = $this->service->create($data);
            return response()->json(['status' => 201, 'message' => 'Feedback created', 'data' => $feedback]);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function update(FeedbackRequest $request, $id)
    {
        try {
            $feedback = Feedback::find($id);
            if (!$feedback) return response()->json(['status' => 404, 'message' => 'Not Found']);

            $updated = $this->service->update($feedback, $request->validated());
            return response()->json(['status' => 200, 'message' => 'Feedback updated', 'data' => $updated]);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        $feedback = Feedback::find($id);
        if (!$feedback) return response()->json(['status' => 404, 'message' => 'Not Found']);

        $feedback->active = !$feedback->active;
        $feedback->save();
        return response()->json(['status' => 200, 'message' => 'Visibility toggled']);
    }
}
