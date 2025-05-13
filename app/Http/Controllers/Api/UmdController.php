<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Umd;
use App\Http\Requests\UmdRequest;
use App\Services\UmdService;
use Exception;
use Illuminate\Support\Facades\Log;

class UmdController extends Controller
{
    protected $service;

    public function __construct(UmdService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Umd::with(['section', 'image'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load UMDs', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $umd = Umd::with(['section', 'image'])->find($id);
            if (!$umd) return $this->sendError('UMD not found', 404);
            return $this->sendResponse($umd);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve UMD', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(UmdRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdUmd = [];

            if (isset($validated['unlock']) && is_array($validated['unlock'])) {
                foreach ($validated['unlock'] as $item) {

                    $item['umd_sec'] = $item['umd_sec'] ?? null;
                    $item['umd_title'] = $item['umd_title'] ?? null;
                    $item['umd_detail'] = $item['umd_detail'] ?? null;
                    $item['umd_routepage'] = $item['umd_routepage'] ?? null;
                    $item['umd_btntext'] = $item['umd_btntext'] ?? null;
                    $item['umd_img'] = $item['umd_img'] ?? null;

                    if (!empty($item['umd_id'])) {
                        // Update existing
                        $existing = Umd::find($item['umd_id']);
                        if ($existing) {
                            $existing->update([
                                'umd_title' => $item['umd_title'],
                                'umd_detail' => $item['umd_detail'],
                                'umd_routepage' => $item['umd_routepage'],
                                'umd_btntext' => $item['umd_btntext'],
                                'umd_img' => $item['umd_img'],
                            ]);
                        
                            $createdUmd[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = Umd::where('umd_sec', $item['umd_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = Umd::create($item);
                           $createdUmd[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdUmd, 201, 'Umd records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/updated umd', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(UmdRequest $request, $id)
    {
        try {

            $unlock = Umd::find($id);
            if (!$unlock) {
                return $this->sendError('unlock not found', 404);
            }

            $data = $request->input('unlock');

            $validated = $request->validate([
                'umd_sec' => 'nullable|integer',
                'umd_title' => 'nullable|string',
                'umd_routepage' => 'nullable|string',
                'umd_btntext' => 'nullable|string',
                'umd_detail' => 'nullable|string',
                'umd_img' => 'nullable|integer',
            ])->validate();

            $unlock->update($validated);

            return $this->sendResponse($unlock, 200, 'Unlock updated successfully');
            return $this->sendResponse([], 200, 'Unlock updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Unlock', 500, ['error' => $e->getMessage()]);
        }
    }

}
