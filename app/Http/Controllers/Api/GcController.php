<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Gc;
use App\Http\Requests\GcRequest;
use App\Services\GcService;
use Exception;
use Illuminate\Support\Facades\Log;

class GcController extends Controller
{
    protected $service;

    public function __construct(GcService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Gc::with(['section', 'image1', 'image2'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load GC', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Gc::with(['section', 'image1', 'image2'])->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch GC', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(GcRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdGc = [];

            if (isset($validated['criteria']) && is_array($validated['criteria'])) {
                foreach ($validated['criteria'] as $item) {

                    $item['gc_sec'] = $item['gc_sec'] ?? null;
                    $item['gc_title'] = $item['gc_title'] ?? null;
                    $item['gc_tag'] = $item['gc_tag'] ?? null;
                    $item['gc_type'] = $item['gc_type'] ?? null;
                    $item['gc_detail'] = $item['gc_detail'] ?? null;
                    $item['gc_img1'] = $item['gc_img1'] ?? null;
                    $item['gc_img2'] = $item['gc_img2'] ?? null;

                    if (!empty($item['gc_id'])) {
                        // Update existing
                        $existing = Gc::find($item['gc_id']);
                        if ($existing) {
                            $existing->update([
                                'gc_title' => $item['gc_title'],
                                'gc_tag' => $item['gc_tag'],
                                'gc_type' => $item['gc_type'],
                                'gc_detail' => $item['gc_detail'],
                                'gc_img1' => $item['gc_img1'],
                                'gc_img2' => $item['gc_img2'],
                            ]);
                            $createdGc[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = Gc::where('gc_sec', $item['gc_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = Gc::create($item);
                            $createdGc[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdGc, 201, 'Gc records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/updated gc', 500, ['error' => $e->getMessage()]);
        }
    }

    // public function update(GcRequest $request, $id)
    // {
    //     try {
    //         $gc = Gc::find($id);
    //         if (!$gc) {
    //             return $this->sendError('Gc not found', 404);
    //         }

    //         $data = $request->input('criteria');

    //         $validated = validator($data,[
    //             'gc_title' => 'nullable|string',
    //             'gc_tag' => 'nullable|string',
    //             'gc_type' => 'nullable|integer',
    //             'gc_detail' => 'nullable|string',
    //             'gc_img1' => 'nullable|integer|exists:tbimage,image_id',
    //             'gc_img2' => 'nullable|integer|exists:tbimage,image_id',
    //         ])->validate();

    //         $gc->update($validated);

    //         return $this->sendResponse($gc, 200, 'Gc updated successfully');
    //         return $this->sendResponse([], 200, 'Gc updated successfully');
    //     } catch (Exception $e) {
    //         return $this->sendError('Failed to update Gc', 500, ['error' => $e->getMessage()]);
    //     }
    // }

    // In app/Http/Controllers/Api/GcController.php

    public function update(GcRequest $request, $id)
    {
        try {
            $gc = Gc::find($id);
            if (!$gc) {
                return $this->sendError('Gc not found', 404);
            }

            $data = $request->input('criteria');

            $validated = validator($data, [
                'gc_title' => 'nullable|string',
                'gc_tag' => 'nullable|string',
                'gc_type' => 'nullable|integer',
                'gc_detail' => 'nullable|string',
                'gc_img1' => 'nullable|integer|exists:tbimage,image_id',
                'gc_img2' => 'nullable|integer|exists:tbimage,image_id',
            ])->validate();

            // *** ADD THIS LINE TO DECODE THE DATA ***
            if (isset($validated['gc_detail'])) {
                $validated['gc_detail'] = base64_decode($validated['gc_detail']);
            }

            $gc->update($validated);

            return $this->sendResponse($gc, 200, 'Gc updated successfully');
            // Note: The second return statement here was unreachable and can be removed.

        } catch (Exception $e) {
            return $this->sendError('Failed to update Gc', 500, ['error' => $e->getMessage()]);
        }
    }
}
