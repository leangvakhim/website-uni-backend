<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\HeaderSection;
use App\Http\Requests\HeaderSectionRequest;
use App\Services\HeaderSectionService;
use Exception;

class HeaderSectionController extends Controller
{
    protected $service;

    public function __construct(HeaderSectionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = HeaderSection::with('section')->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load data', 500, ['error' => $e->getMessage()]);
        }
    }
    public function show(string $id)
    {
        try {
            $header = HeaderSection::with('section')->find($id);
            if (!$header) {
                return $this->sendError('Header not found', 404);
            }
            return $this->sendResponse($header);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve header', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(HeaderSectionRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdHeaderSection = [];

            if (isset($validated['headersection']) && is_array($validated['headersection'])) {
                foreach ($validated['headersection'] as $item) {

                    $item['hsec_sec'] = $item['hsec_sec'] ?? null;
                    $item['hsec_title'] = $item['hsec_title'] ?? null;
                    $item['hsec_subtitle'] = $item['hsec_subtitle'] ?? null;
                    $item['hsec_btntitle'] = $item['hsec_btntitle'] ?? null;
                    $item['hsec_routepage'] = $item['hsec_routepage'] ?? null;
                    $item['hsec_amount'] = $item['hsec_amount'] ?? null;

                    $createdHeaderSection[] = HeaderSection::create($item);
                }
            }

            return $this->sendResponse($createdHeaderSection, 201, 'HeaderSection records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create HeaderSection', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(HeaderSectionRequest $request, $id)
    {
        try {
            $headersection = HeaderSection::find($id);
            if (!$headersection) {
                return $this->sendError('HeaderSection not found', 404);
            }

            $request->merge($request->input('headersection'));

            $validated = $request->validate([
                'hsec_title' => 'required|string',
                'hsec_subtitle' => 'nullable|string',
                'hsec_btntitle' => 'nullable|string',
                'hsec_routepage' => 'nullable|string',
                'hsec_sec' => 'nullable|integer',
                'hsec_amount' => 'nullable|integer',
            ]);

            $headersection->update($validated);

            return $this->sendResponse($headersection, 200, 'study updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update study', 500, ['error' => $e->getMessage()]);
        }
    }
}
