<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\RsdRequest;
use App\Models\Rsd;
use App\Services\RsdService;
use Exception;
use Illuminate\Http\Request;

class RsdController extends Controller
{
    protected $rsdService;

    public function __construct(RsdService $rsdService)
    {
        $this->rsdService = $rsdService;
    }

    public function index()
    {
        try {
            $data = Rsd::with(['image', 'text'])->where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch RSD', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Rsd::with(['image', 'text'])->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('RSD not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching RSD', 500, ['error' => $e->getMessage()]);
        }
    }


    public function create(RsdRequest $request)
    {
        try {
            $data = $request->validated();
            if (!isset($data['rsd_order'])) {
                $data['rsd_order'] = Rsd::max('rsd_order') + 1;
            }
    
            $rsd = Rsd::create($data);
            return $this->sendResponse($rsd, 201, 'Rsd created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Rsd', 500, ['error' => $e->getMessage()]);
        }
    }
    

    public function update(RsdRequest $request, $id)
    {
        try {
            $rsd = Rsd::find($id);
            if (!$rsd) return $this->sendError('RSD not found', 404);
            $updated = $this->rsdService->update($rsd, $request->validated());
            return $this->sendResponse($updated, 200, 'RSD updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update RSD', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $rsd = Rsd::find($id);
            if (!$rsd) return $this->sendError('RSD not found', 404);
            $rsd->active = !$rsd->active;
            $rsd->save();
            return $this->sendResponse([], 200, 'RSD visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function duplicate($id)
    {
        try {
            $rsd = Rsd::find($id);

            if (!$rsd) {
                return $this->sendError('RSD not found', 404);
            }

            $newRsd = $rsd->replicate();
            $newRsd->rsd_title = $rsd->rsd_title . ' (Copy)';
            $newRsd->rsd_order = Rsd::max('rsd_order') + 1;
            $newRsd->save();

            return $this->sendResponse($newRsd, 200, 'RSD duplicated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to duplicate RSD', 500, ['error' => $e->getMessage()]);
        }
    }

    public function reorder(Request $request)
    {
        try {
            $data = $request->validate([
                '*.rsd_id' => 'required|integer|exists:tbrsd,rsd_id',
                '*.rsd_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Rsd::where('rsd_id', $item['rsd_id'])->update(['rsd_order' => $item['rsd_order']]);
            }

            return response()->json([
                'message' => 'RSD order updated successfully',
            ], 200);
        } catch (Exception $e) {
            return $this->sendError('Failed to reorder RSD', 500, ['error' => $e->getMessage()]);
        }
    }
}