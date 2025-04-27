<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\RsdTitle;
use App\Http\Requests\RsdTitleRequest;
use Exception;
use Illuminate\Http\Request;

class RsdTitleController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = RsdTitle::where('active', 1);

            if ($request->has('rsdt_text')) {
                $query->where('rsdt_text', $request->input('rsdt_text'));
            }

            $data = $query->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve records', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = RsdTitle::find($id);
            if (!$data) {
                return $this->sendError('Record not found', 404);
            }
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(RsdTitleRequest $request)
    {
        try {
            $validated = $request->validated();

            if (!isset($validated['rsdt_order'])) {
                $validated['rsdt_order'] = (RsdTitle::where('rsdt_text', $validated['rsdt_text'])->max('rsdt_order') ?? 0) + 1;
            }


            $validated['rsdt_title'] = $validated['rsdt_title'] ?? 1;
            $validated['rsdt_text'] = $validated['rsdt_text'] ?? 1;
            $validated['rsdt_code'] = $validated['rsdt_code'] ?? 1;
            $validated['rsdt_type'] = $validated['rsdt_type'] ?? 1;
            $validated['display'] = $validated['display'] ?? 1;
            $validated['active'] = $validated['active'] ?? 1;

            $data = RsdTitle::create($validated);
            return $this->sendResponse($data, 201, 'RsdTitle created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create RsdTitle', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(RsdTitleRequest $request, $id)
    {
        try {
            $rsd = RsdTitle::find($id);
            if (!$rsd) return $this->sendError('Record not found', 404);

            if ($request->has('display')) {
                $rsd->display = $request->input('display');
            }

            $rsd->update($request->validated());
            return $this->sendResponse($rsd, 200, 'RsdTitle updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update RsdTitle', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $rsd = RsdTitle::find($id);
            if (!$rsd) {
                return $this->sendError('Record not found', 404);
            }
            $rsd->active = $rsd->active == 1 ? 0 : 1;
            $rsd->save();
            return $this->sendResponse([], 200, 'Visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function getByRsd($rsd_id)
    {
        $records = RsdTitle::where('rsdt_text', $rsd_id)
            ->where('active', 1)
            ->orderBy('rsdt_order', 'asc')
            ->get();

        return response()->json(['data' => $records]);
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            '*.rsdt_id' => 'required|integer|exists:rsd_titles,rsdt_id',
            '*.rsdt_order' => 'required|integer'
        ]);

        foreach ($data as $item) {
            RsdTitle::where('rsdt_id', $item['rsdt_id'])->update(['rsdt_order' => $item['rsdt_order']]);
        }

        return response()->json(['message' => 'RsdTitle order updated successfully'], 200);
    }

    public function syncRsdTitles(Request $request)
    {
        $rsd_id = $request->input('rsdt_text');

        if (!$rsd_id) {
            return response()->json(['message' => 'Missing rsdt_text'], 400);
        }

        $titles = $request->input('research_title', []);

        $existingIds = collect($titles)
            ->pluck('rsdt_id')
            ->filter(fn($id) => !is_null($id))
            ->unique()
            ->values()
            ->toArray();

        if (!empty($existingIds)) {
            RsdTitle::where('rsdt_text', $rsd_id)
                ->whereNotIn('rsdt_id', $existingIds)
                ->where('active', '!=', 0)
                ->delete();
        }

        foreach ($titles as $title) {
            $existing = RsdTitle::where('rsdt_id', $title['rsdt_id'] ?? 0)
                ->where('rsdt_text', $rsd_id)
                ->first();

            if ($existing) {
                $existing->update([
                    'rsdt_order' => $title['rsdt_order'],
                    'rsdt_type' => $title['rsdt_type'] ?? '',
                    'rsdt_code' => $title['rsdt_type'] . "-" . $existing->rsdt_id,
                    'active' => $title['active'] ?? 1,
                ]);
                continue;
            } else {
                $created = RsdTitle::create([
                    'rsdt_text' => $rsd_id,
                    'rsdt_order' => $title['rsdt_order'],
                    'rsdt_type' => $title['rsdt_type'] ?? '',
                    'rsdt_code' => $title['rsdt_type'] . "-" . $title['rsdt_id'],
                    'active' => $title['active'] ?? 1,
                ]);

                $created->update([
                    'rsdt_code' => $created->rsdt_type . '-' . $created->rsdt_id,
                ]);
            }
        }

        return response()->json([
            'message' => 'RsdTitles synced successfully',
            'data' => $titles,
        ], 200);
    }
}
