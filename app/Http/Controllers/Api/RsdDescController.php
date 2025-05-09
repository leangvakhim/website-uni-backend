<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\RsdDesc;
use App\Services\RsdDescService;
use App\Http\Requests\RsdDescRequest;
use Exception;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Log;

class RsdDescController extends Controller
{
    protected $service;

    public function __construct(RsdDescService $service)
    {
        $this->service = $service;
    }

    public function index(HttpRequest $request)
    {
        $query = RsdDesc::with('title');

        if ($request->has('rsdd_rsdtile')) {
            $query->where('rsdd_rsdtile', $request->input('rsdd_rsdtile'));
        }

        $data = $query->get();
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
                    $item['rsdd_title'] = $item['rsdd_title'] ?? null;
                    $item['rsdd_details'] = $item['rsdd_details'] ?? null;
                    $item['rsdd_rsdtile'] = $item['rsdd_rsdtile'] ?? null;

                    if (!empty($item['rsdd_id'])) {
                        // Update existing
                        $existing = RsdDesc::find($item['rsdd_id']);
                        if ($existing) {
                            $existing->update([
                                'rsdd_title' => $item['rsdd_title'],
                                'rsdd_details' => $item['rsdd_details'],
                                'rsdd_rsdtile' => $item['rsdd_rsdtile'],
                            ]);
                            $createdRsdDesc[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = RsdDesc::where('rsdd_title', $item['rsdd_title'])
                            ->where('rsdd_rsdtile', $item['rsdd_rsdtile'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = RsdDesc::create($item);
                            $createdRsdDesc[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdRsdDesc, 201, 'RsdDesc records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update RsdDesc', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RsdDescRequest $request, $id)
    {
        try {
            $RsdDesc = RsdDesc::find($id);
            if (!$RsdDesc) {
                return $this->sendError('RsdDesc not found', 404);
            }

            $data = $request->input('research_desc');

            $validated = validator($data, [
                'rsdd_title' => 'nullable|string|max:255',
                'rsdd_details' => 'nullable|string',
                'rsdd_rsdtile' => 'nullable|integer',
            ])->validate();

            $RsdDesc->update($validated);

            return $this->sendResponse($RsdDesc, 200, 'RsdDesc updated successfully');
            return $this->sendResponse([], 200, 'RsdDesc updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update RsdDesc', 500, ['error' => $e->getMessage()]);
        }
    }
}
