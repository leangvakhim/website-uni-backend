<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\AcademicRequest;
use App\Models\Academic;
use App\Services\AcademicService;
use Exception;

class AcademicController extends Controller
{
    protected $service;

    public function __construct(AcademicService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Academic::with(['section', 'image'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch academic', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $item = Academic::with(['section', 'image'])->find($id);
            return $item ? $this->sendResponse($item) : $this->sendError('Academic not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Failed to load academic', 500, ['error' => $e->getMessage()]);
        }
    }

    public function store(AcademicRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdAcademic = [];

            if (isset($validated['academics']) && is_array($validated['academics'])) {
                foreach ($validated['academics'] as $item) {

                    $item['acad_title'] = $item['acad_title'] ?? null;
                    $item['acad_detail'] = $item['acad_detail'] ?? null;
                    $item['acad_img'] = $item['acad_img'] ?? null;
                    $item['acad_btntext1'] = $item['acad_btntext1'] ?? null;
                    $item['acad_btntext2'] = $item['acad_btntext2'] ?? null;
                    $item['acad_routepage'] = $item['acad_routepage'] ?? null;
                    $item['acad_routetext'] = $item['acad_routetext'] ?? null;

                    if (!empty($item['acad_id'])) {
                        // Update existing
                        $existing = Academic::find($item['acad_id']);
                        if ($existing) {
                            $existing->update([
                                'acad_title' => $item['acad_title'],
                                'acad_detail' => $item['acad_detail'],
                                'acad_img' => $item['acad_img'],
                                'acad_btntext1' => $item['acad_btntext1'],
                                'acad_btntext2' => $item['acad_btntext2'],
                                'acad_routepage' => $item['acad_routepage'],
                                'acad_routetext' => $item['acad_routetext'],
                            ]);
                            $createdAcademic[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = Academic::where('acad_sec', $item['acad_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = Academic::create($item);
                            $createdAcademic[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdAcademic, 201, 'Academic records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update Academic', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(AcademicRequest $request, $id)
    {
        try {
            $Academic = Academic::find($id);
            if (!$Academic) {
                return $this->sendError('Academic not found', 404);
            }

            $data = $request->input('academics');

            $validated = validator($data, [
                'acad_title' => 'nullable|string',
                'acad_detail' => 'nullable|string',
                'acad_img' => 'nullable|integer',
                'acad_sec' => 'nullable|integer',
                'acad_btntext1' => 'nullable|string',
                'acad_btntext2' => 'nullable|string',
                'acad_routepage' => 'nullable|string',
                'acad_routetext' => 'nullable|string',
            ])->validate();

            $Academic->update($validated);

            return $this->sendResponse($Academic, 200, 'Academic updated successfully');
            return $this->sendResponse([], 200, 'Academic updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Academic', 500, ['error' => $e->getMessage()]);
        }
    }
}
