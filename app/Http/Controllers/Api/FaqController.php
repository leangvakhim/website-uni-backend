<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Faq;
use App\Http\Requests\FaqRequest;
use App\Services\FaqService;
use Exception;

class FaqController extends Controller
{
    protected $service;

    public function __construct(FaqService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Faq::with('section')->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load FAQs', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $faq = Faq::with('section')->find($id);
            if (!$faq) {
                return $this->sendError('FAQ not found', 404);
            }
            return $this->sendResponse($faq);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve FAQ', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(FaqRequest $request)
    {
        try {
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'FAQ created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(FaqRequest $request, $id)
    {
        try {
            $faq = Faq::find($id);
            if (!$faq) return $this->sendError('Not found', 404);
            $updated = $this->service->update($faq, $request->validated());
            return $this->sendResponse($updated, 200, 'Updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
