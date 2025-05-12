<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\RasRequest;
use App\Models\Ras;
use App\Services\RasService;
use Exception;

class RasController extends Controller
{
    protected $service;

    public function __construct(RasService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Ras::with(['section', 'text', 'image1', 'image2'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch Ras', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $ras = Ras::with(['section', 'text', 'image1', 'image2'])->find($id);
            if (!$ras) return $this->sendError('Ras not found', 404);
            return $this->sendResponse($ras);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch Ras', 500, ['error' => $e->getMessage()]);
        }
    }

    // public function create(RasRequest $request)
    // {
    //     try {
    //         $validated = $request->validated();
    //         $createdRas = [];

    //         if (isset($validated['specialization']) && is_array($validated['specialization'])) {
    //             foreach ($validated['specialization'] as $item) {

    //                 $item['ras_sec'] = $item['ras_sec'] ?? null;
    //                 $item['ras_text'] = $item['ras_text'] ?? null;
    //                 $item['ras_img1'] = $item['ras_img1'] ?? null;
    //                 $item['ras_img2'] = $item['ras_img2'] ?? null;

    //                 $createdRas[] = Ras::create($item);
    //             }
    //         }

    //         return $this->sendResponse($createdRas, 201, 'Ras records created successfully');
    //     } catch (Exception $e) {
    //         return $this->sendError('Failed to create ras', 500, ['error' => $e->getMessage()]);
    //     }
    // }

    // public function update(RasRequest $request, $id)
    // {
    //     try {
    //         $ras = Ras::find($id);
    //         if (!$ras) {
    //             return $this->sendError('Ras not found', 404);
    //         }

    //         $request->merge($request->input('specialization'));

    //         $validated = $request->validate([
    //             'ras_text' => 'nullable|integer',
    //             'ras_img1' => 'nullable|integer',
    //             'ras_img2' => 'nullable|integer',
    //             'af_sec' => 'nullable|integer',
    //         ]);

    //         $ras->update($validated);

    //         return $this->sendResponse($ras, 200, 'Ras updated successfully');
    //     } catch (Exception $e) {
    //         return $this->sendError('Failed to update Ras', 500, ['error' => $e->getMessage()]);
    //     }
    // }

    public function create(RasRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdRas = [];

            if (isset($validated['specialization']) && is_array($validated['specialization'])) {
                foreach ($validated['specialization'] as $item) {

                    // $item['af_text'] = $item['af_text'] ?? null;
                    // $item['af_sec'] = $item['af_sec'] ?? null;
                    // $item['af_img'] = $item['af_img'] ?? null;

                    $item['ras_sec'] = $item['ras_sec'] ?? null;
                    $item['ras_text'] = $item['ras_text'] ?? null;
                    $item['ras_img1'] = $item['ras_img1'] ?? null;
                    $item['ras_img2'] = $item['ras_img2'] ?? null;


                    if (!empty($item['ras_id'])) {
                        // Update existing
                        $existing = Ras::find($item['ras_id']);
                        if ($existing) {
                            $existing->update([
                                'ras_text' => $item['ras_text'],
                                'ras_sec' => $item['ras_sec'],
                                'ras_img1' => $item['ras_img1'],
                                'ras_img2' => $item['ras_img2'],
                            ]);
                            $createdRas[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = Ras::where('ras_sec', $item['ras_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = Ras::create($item);
                            $createdRas[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdRas, 201, 'Ras records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update Ras', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RasRequest $request, $id)
    {
        try {
            $ras = Ras::find($id);
            if (!$ras) {
                return $this->sendError('ras not found', 404);
            }

            $data = $request->input('specialization');

            $validated = validator($data, [
                'ras_text' => 'nullable|integer',
                'ras_img1' => 'nullable|integer',
                'ras_img2' => 'nullable|integer',
                'ras_sec' => 'nullable|integer',
            ])->validate();

            $ras->update($validated);

            return $this->sendResponse($ras, 200, 'ras updated successfully');
            return $this->sendResponse([], 200, 'ras updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update ras', 500, ['error' => $e->getMessage()]);
        }
    }
}
