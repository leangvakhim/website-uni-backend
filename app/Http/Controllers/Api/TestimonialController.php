<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Testimonial;
use App\Http\Requests\TestimonialRequest;
use App\Services\TestimonialService;
use Exception;

class TestimonialController extends Controller
{
    protected $service;

    public function __construct(TestimonialService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Testimonial::with(['section'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load testimonials', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $testimonial = Testimonial::with(['section'])->find($id);
            if (!$testimonial) {
                return $this->sendError('Testimonial not found', 404);
            }
            return $this->sendResponse($testimonial);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve testimonial', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(TestimonialRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdTestimonials = [];

            if (isset($validated['testimonials']) && is_array($validated['testimonials'])) {
                foreach ($validated['testimonials'] as $item) {

                    $item['t_title'] = $item['t_title'] ?? null;
                    $item['t_sec'] = $item['t_sec'] ?? null;

                     if (!empty($item['t_id'])) {
                        // Update existing
                        $existing = Testimonial::find($item['t_id']);
                        if ($existing) {
                            $existing->update([
                                't_title' => $item['t_tile'],
                                
                            ]);
                            $createdTestimonials[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = Testimonial::where('t_sec', $item['t_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = Testimonial::create($item);
                            $createdTestimonials[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdTestimonials, 201, 'Testimonials records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to created/updated testimonials', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(TestimonialRequest $request, $id)
    {
        try {
            $testimonial = Testimonial::find($id);
            if (!$testimonial) {
                return $this->sendError('Testimonial not found', 404);
            }

            $data = $request->input('testimonials');

            $validated = $request->validate([
                't_title' => 'required|string',
                't_sec' => 'nullable|integer'
            ])->validate();

            $testimonial->update($validated);

            return $this->sendResponse($testimonial, 200, 'testimonials updated successfully');
            return $this->sendResponse([], 200, 'testimonials updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update testimonials', 500, ['error' => $e->getMessage()]);
        }
    }
}
