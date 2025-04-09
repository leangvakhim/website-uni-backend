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
            $subhas = Subha::with(['ha'])->where('active', 1)->get();
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
            $data = $request->validated();

            if (!isset($data['sha_order'])) {
                $data['sha_order'] = Subha::max('sha_order') + 1;
            }

            $created = app(SubhaService::class)->create($data);

            return $this->sendResponse($created, 201, 'Subha created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Subha', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $subha = Subha::find($id);
            if (!$subha) return $this->sendError('Subha not found', 404);

            $updated = $this->subhaService->update($subha, $request->all());
            $updated->load(['ha']);

            return $this->sendResponse($updated, 200, 'Subha updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Subha', 500, ['error' => $e->getMessage()]);
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
