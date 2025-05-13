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
            $validated = $request->validated();
            $createdFaq = [];

            if (isset($validated['faq']) && is_array($validated['faq'])) {
                foreach ($validated['faq'] as $item) {

                    $item['faq_sec'] = $item['faq_sec'] ?? null;
                    $item['faq_title'] = $item['faq_title'] ?? null;
                    $item['faq_subtitle'] = $item['faq_subtitle'] ?? null;

                   if (!empty($item['faq_id'])) {
                        // Update existing
                        $existing = Faq::find($item['faq_id']);
                        if ($existing) {
                            $existing->update([
                                'faq_title' => $item['faq_title'],
                                'faq_subtitle' => $item['faq_subtitle'],
                                
                            ]);
                            $createdFaq[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = Faq::where('faq_sec', $item['faq_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = Faq::create($item);
                           $createdFaq[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdFaq, 201, 'Faq records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update faq', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(FaqRequest $request, $id)
    {
        try {
            $faq = Faq::find($id);
            if (!$faq) {
                return $this->sendError('Faq not found', 404);
            }

           $data = $request->input('faq');

            $validated = $request->validate([
                'faq_title' => 'nullable|string',
                'faq_subtitle' => 'nullable|string',
                'faq_sec' => 'nullable|integer',
    
            ])->validate();

            $faq->update($validated);

            return $this->sendResponse($faq, 200, 'Faq updated successfully');
            return $this->sendResponse([], 200, 'Faq updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Faq', 500, ['error' => $e->getMessage()]);
        }
    }
}
