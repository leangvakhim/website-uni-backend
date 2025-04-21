<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Developer;
use App\Http\Requests\DeveloperRequest;
use Exception;

class DeveloperController extends Controller
{
    public function index()
    {
        try {
            $data = Developer::with('img')->where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load developers', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $developer = Developer::with('img')->find($id);
            if (!$developer) return $this->sendError('Developer not found', 404);
            return $this->sendResponse($developer);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve developer', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(DeveloperRequest $request)
    {
        try {
            $validated = $request->validated();
            $created = [];

            if (isset($validated['developer']) && is_array($validated['developer'])) {
                foreach ($validated['developer'] as $item) {
                    $item['d_img'] = $item['d_img'] ?? null;
                    $item['d_name'] = $item['d_name'] ?? null;
                    $item['d_position'] = $item['d_position'] ?? null;
                    $item['d_write'] = $item['d_write'] ?? null;
                    $item['lang'] = $item['lang'] ?? 1;
                    $item['d_order'] = (Developer::max('d_order') ?? 0) + 1;
                    $item['display'] = $item['display'] ?? 1;
                    $item['active'] = $item['active'] ?? 1;

                    $created[] = Developer::create($item);
                }
            }

            return $this->sendResponse($created, 201, 'Developer records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create developer', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(DeveloperRequest $request, $id)
    {
        try {
            $developer = Developer::find($id);
            if (!$developer) return $this->sendError('Developer not found', 404);

            $request->merge($request->input('developer'));

            $validated = $request->validate([
                'd_name' => 'required|string|max:50',
                'd_position' => 'required|string|max:50',
                'd_write' => 'nullable|string',
                'd_img' => 'nullable|integer|exists:tbimage,image_id',
                'lang' => 'nullable|in:1,2',
                'd_order' => 'nullable|integer',
                'display' => 'nullable|boolean',
                'active' => 'nullable|boolean',
            ]);

            $developer->update($validated);

            return $this->sendResponse($developer, 200, 'Developer updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update developer', 500, ['error' => $e->getMessage()]);
        }
    }

    
    public function visibility($id)
    {
        try {
            $developer = Developer::find($id);
            if (!$developer) return $this->sendError('Developer not found', 404);

            $developer->active = !$developer->active;
            $developer->save();

            return $this->sendResponse([], 200, 'Developer visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function reorder(Request $request)
    {
        try {
            $data = $request->validate([
                '*.d_id' => 'required|integer|exists:developers,d_id',
                '*.d_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Developer::where('d_id', $item['d_id'])->update([
                    'd_order' => $item['d_order']
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Developer order updated successfully',
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to reorder developer', 500, ['error' => $e->getMessage()]);
        }
    }

    public function duplicate($id)
    {
        try {
            $developer = Developer::find($id);
            if (!$developer) return $this->sendError('Developer not found', 404);

            $newDeveloper = $developer->replicate();
            $newDeveloper->d_name = $developer->d_name . ' (Copy)';
            $newDeveloper->d_order = Developer::max('d_order') + 1;
            $newDeveloper->save();

            return response()->json(['message' => 'Developer duplicated', 'data' => $newDeveloper], 200);
        } catch (Exception $e) {
            return $this->sendError('Failed to duplicate developer', 500, ['error' => $e->getMessage()]);
        }
    }


}
