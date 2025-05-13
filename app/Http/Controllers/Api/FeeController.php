<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Fee;
use App\Http\Requests\FeeRequest;
use App\Services\FeeService;
use Exception;

class FeeController extends Controller
{
    protected $service;

    public function __construct(FeeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Fee::with(['section', 'image'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load Fee', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Fee::with(['section', 'image'])->find($id);
            if (!$data) return $this->sendError('Fee not found', 404);
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve Fee', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(FeeRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdFee = [];

            if (isset($validated['fee']) && is_array($validated['fee'])) {
                foreach ($validated['fee'] as $item) {

                    $item['fe_sec'] = $item['fe_sec'] ?? null;
                    $item['fe_title'] = $item['fe_title'] ?? null;
                    $item['fe_desc'] = $item['fe_desc'] ?? null;
                    $item['fe_img'] = $item['fe_img'] ?? null;
                    $item['fe_price'] = $item['fe_price'] ?? null;

                    if (!empty($item['fee_id'])) {
                        // Update existing
                        $existing = Fee::find($item['fee_id']);
                        if ($existing) {
                            $existing->update([
                                'fe_title' => $item['fe_title'],
                                'fe_desc' => $item['fe_desc'],
                                'fe_img' => $item['fe_img'],
                                'fe_price' => $item['fe_price'],
                               
                            ]);
                           $createdFee[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = Fee::where('fe_sec', $item['fe_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = Fee::create($item);
                            $createdFee[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdFee, 201, 'Fee records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update fee', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(FeeRequest $request, $id)
    {
        try {
            $fee = Fee::find($id);
            if (!$fee) {
                return $this->sendError('Fee not found', 404);
            }

            $data = $request->input('fee');

            $validated = $request->validate([
                'fe_title' => 'required|string',
                'fe_desc' => 'nullable|string',
                'fe_img' => 'nullable|integer',
                'fe_price' => 'nullable|string',
                'fe_sec' => 'nullable|integer',
            ])->validate();

            $fee->update($validated);

            return $this->sendResponse($fee, 200, 'fee updated successfully');
             return $this->sendResponse([], 200, 'fee updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update fee', 500, ['error' => $e->getMessage()]);
        }
    }
}
