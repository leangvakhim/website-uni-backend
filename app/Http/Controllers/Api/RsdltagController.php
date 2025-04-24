<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Rsdltag;
use App\Services\RsdltagService;
use App\Http\Requests\RsdltagRequest;
use App\Models\Rsdl;
use Exception;
use Illuminate\Support\Facades\Log;

class RsdltagController extends Controller
{
    protected $rsdltagService;

    public function __construct(RsdltagService $rsdltagService)
    {
        $this->rsdltagService = $rsdltagService;
    }

    public function index()
    {
        try {
            $data = Rsdltag::with([
                'rsdl:rsdl_id,rsdl_title',
                'img:image_id,img'
            ])
            ->where('active', 1)
            ->get();

            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve RSDL Tags', 500, ['error' => $e->getMessage()]);
        }
    }


    public function show($id)
    {
        try {
            $item = Rsdltag::with([
                'rsdl:rsdl_id,rsdl_title',
                'img:image_id,img'
            ])->find($id);

            if (!$item)
                return $this->sendError('RSDL Tag not found', 404);

            return $this->sendResponse($item);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve RSDL Tag', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(RsdltagRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdRsdltag = [];

            if (!isset($validated['rsdl_id'])) {
                return $this->sendError('Researchlab ID is required', 422);
            }

            $rsdl = Rsdl::find($validated['rsdl_id']);
            if (!$rsdl) {
                return $this->sendError('Researchlab not found', 404);
            }

            if (isset($validated['rsdlt_tags']) && is_array($validated['rsdlt_tags'])) {
                foreach ($validated['rsdlt_tags'] as $item) {
                    $item['rsdlt_rsdl'] = $rsdl->rsdl_id;

                    $item['active'] = $item['active'] ?? 1;

                    $createdRsdltag[] = Rsdltag::create($item);
                }
            }

            return $this->sendResponse($createdRsdltag, 201, 'Researchlab tag records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create researchlab tag', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $rsdltag = Rsdltag::find($id);
            if (!$rsdltag) {
                return $this->sendError('RSDL tag not found', 404);
            }

            $validated = $request->validate([
                'rsdlt_tags' => 'required|array',
                'rsdlt_tags.*.rsdlt_title' => 'required|string',
                'rsdlt_tags.*.rsdlt_img' => 'nullable|integer|exists:tbimage,image_id',
                'rsdlt_tags.*.rsdlt_rsdl' => 'required|integer|exists:tbrsdl,rsdl_id',
            ]);

            $updates = [];

            foreach ($validated['rsdlt_tags'] as $tagData) {
                $tag = Rsdltag::find($id);
                if (!$tag) {
                    return $this->sendError('RSDL tag not found', 404);
                }

                $tag->update([
                    'rsdlt_title' => $tagData['rsdlt_title'],
                    'rsdlt_img' => $tagData['rsdlt_img'] ?? null,
                    'rsdlt_rsdl' => $tagData['rsdlt_rsdl'],
                ]);
            }
            return $this->sendResponse($rsdltag, 200, 'RSDL tag updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update RSDL tag', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $rsdltag = Rsdltag::find($id);
            if (!$rsdltag) return $this->sendError('rsdltag not found', 404);

            $rsdltag->active = !$rsdltag->active;
            $rsdltag->save();
            return $this->sendResponse([], 200, 'rsdltag visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            '*.rsdlt_id' => 'required|integer|exists:tbrsdl,rsdl_id', // <-- fix table name
        ]);


        foreach ($data as $item) {
            Rsdltag::where('rsdl_id', $item['rsdl_id'])->update(['rsdl_order' => $item['rsdl_order']]);
        }

        return response()->json([
            'message' => 'rsdl order updated successfully',
        ], 200);
    }
}