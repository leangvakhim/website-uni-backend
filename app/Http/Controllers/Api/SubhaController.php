<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Subha;
use App\Services\SubhaService;
use App\Http\Requests\SubhaRequest;
use Illuminate\Http\Request;
use Exception;

class SubhaController extends Controller
{
    protected $subhaService;

    public function __construct(SubhaService $subhaService)
    {
        $this->subhaService = $subhaService;
    }

    public function index()
    {
        try {
            $subhas = Subha::with(['ha'])
                ->where('active', 1)
                ->orderBy('sha_order', 'asc')
                ->get();
            return $this->sendResponse($subhas->count() === 1 ? $subhas->first() : $subhas);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve Subha', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $subha = Subha::with(['ha'])->find($id);
            if (!$subha) return $this->sendError('Subha not found', 404);
            return $this->sendResponse($subha);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve Subha', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(SubhaRequest $request)
    {
        try {
            $validated = $request->validated();
            $subapplys = $validated['subapply'] ?? [];

            if (empty($subapplys)) {
                return $this->sendError('No faqs Data Provided', 422);
            }

            $createdsubapplys = [];

            foreach ($subapplys as $item) {
                if (!isset($item['sha_ha'])) {
                    return $this->sendError('faq ID is required', 422);
                }

                $item['sha_order'] = (Subha::where('sha_ha', $item['sha_ha'])->max('sha_order') ?? 0) + 1;

                $item['sha_title'] = $item['sha_title'] ?? null;
                $item['display'] = $item['display'] ?? 1;
                $item['active'] = $item['active'] ?? 1;

                $subapplys = Subha::create($item);
                $createdsubapplys[] = $subapplys;
            }

            return $this->sendResponse($createdsubapplys, 201, 'Subapply created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Subapply', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(SubhaRequest $request, $id)
    {
        try {

            $subapplys = Subha::find($id);
            if (!$subapplys) {
                return $this->sendError('subapplys not found', 404);
            }

            $subapplyData = $request->input('subapply');
            if (!$subapplyData || !is_array($subapplyData)) {
                return $this->sendError('Invalid subapply data provided', 422);
            }
            $request->merge($subapplyData);

            $validated = $request->validate([
                'sha_title' => 'nullable|string',
                'sha_ha' => 'nullable|integer',
                'display' => 'nullable|integer',
            ]);

            $subapplys->update($validated);

            return $this->sendResponse($subapplys, 200, 'subapply updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update subapply', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $subha = Subha::find($id);
            if (!$subha) return $this->sendError('Subha not found', 404);
            $subha->active = $subha->active ? 0 : 1;
            $subha->save();
            return $this->sendResponse([], 200, 'Visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function reorder(Request $request)
    {
        try {
            $data = $request->validate([
                '*.sha_id' => 'required|integer|exists:tbsubha,sha_id',
                '*.sha_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Subha::where('sha_id', $item['sha_id'])->update([
                    'sha_order' => $item['sha_order']
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Subha order updated successfully',
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to reorder Subha', 500, ['error' => $e->getMessage()]);
        }
    }
}
