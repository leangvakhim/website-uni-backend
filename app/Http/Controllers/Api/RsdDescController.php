<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\RsdDesc;
use App\Services\RsdDescService;
use App\Http\Requests\RsdDescRequest;
use Exception;

class RsdDescController extends Controller
{
    protected $service;

    public function __construct(RsdDescService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = RsdDesc::with('title')->get();
        return $this->sendResponse($data);
    }

    public function show($id)
    {
        $desc = RsdDesc::with('title')->find($id);
        return $desc ? $this->sendResponse($desc) : $this->sendError('Not found', 404);
    }

    public function create(RsdDescRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdRsdDesc = [];

            if (isset($validated['research_desc']) && is_array($validated['research_desc'])) {
                foreach ($validated['research_desc'] as $item) {

                    $item['rsdd_rsdtitle'] = $item['rsdd_rsdtitle'] ?? null;
                    $item['rsdd_details'] = $item['rsdd_details'] ?? null;

                    $createdRsdDesc[] = RsdDesc::create($item);
                }
            }

            return $this->sendResponse($createdRsdDesc, 201, 'RsdDesc records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create RsdDesc', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RsdDescRequest $request, $id)
    {
        try {
            $RsdDesc = RsdDesc::find($id);
            if (!$RsdDesc) {
                return $this->sendError('RsdDesc not found', 404);
            }

            $request->merge($request->input('research_desc'));

            $validated = $request->validate([
                'rsdd_rsdtitle' => 'nullable|string|max:255',
                'rsdd_details' => 'nullable|string',

            ]);

            $RsdDesc->update($validated);

            return $this->sendResponse($RsdDesc, 200, 'RsdDesc updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update RsdDesc', 500, ['error' => $e->getMessage()]);
        }
    }
}
