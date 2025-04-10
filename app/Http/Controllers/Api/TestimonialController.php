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

                    $createdTestimonials[] = Testimonial::create($item);
                }
            }

            return $this->sendResponse($createdTestimonials, 201, 'Testimonials records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create testimonials', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(TestimonialRequest $request, $id)
    {
        try {
            $testimonial = Testimonial::find($id);
            if (!$testimonial) return $this->sendError('Testimonial not found', 404);

            $updated = $this->service->update($testimonial, $request->validated());
            return $this->sendResponse($updated, 200, 'Testimonial updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
