<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Developersocial;
use App\Http\Requests\DevelopersocialRequest;
use Illuminate\Http\Request;
use Exception;

class DevelopersocialController extends Controller
{
    public function index()
    {
        try {
            $data = Developersocial::with(['developer', 'img'])
                ->where('active', 1)
                ->orderBy('ds_order', 'asc')
                ->get();

            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch Developersocial data', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Developersocial::with(['developer', 'img'])->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Developersocial not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching Developersocial', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(DevelopersocialRequest $request)
    {
        try {
            $validated = $request->validated();
            $created = [];

            if (isset($validated['developer_social']) && is_array($validated['developer_social'])) {
                foreach ($validated['developer_social'] as $item) {
                    $item['ds_title'] = $item['ds_title'] ?? null;
                    $item['ds_link'] = $item['ds_link'] ?? null;
                    $item['ds_developer'] = $item['ds_developer'] ?? null;
                    $item['ds_img'] = $item['ds_img'] ?? null;

                    $item['ds_order'] = (Developersocial::where('ds_developer', $item['ds_developer'])->max('ds_order') ?? 0) + 1;
                    $item['display'] = $item['display'] ?? 1;
                    $item['active'] = $item['active'] ?? 1;

                    $created[] = Developersocial::create($item);
                }
            }

            return $this->sendResponse($created, 201, 'Developersocial records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Developersocial', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(DevelopersocialRequest $request, $id)
    {
        try {
            $record = Developersocial::find($id);
            if (!$record) {
                return $this->sendError('Developersocial not found', 404);
            }

            $request->merge($request->input('social'));

            $validated = $request->validate([
                'ds_title'     => 'nullable|string|max:50',
                'ds_img'       => 'nullable|integer|exists:tbimage,image_id',
                'ds_developer' => 'nullable|integer|exists:tbdeveloper,d_id',
                'ds_link'      => 'nullable|url',
                'ds_order'     => 'nullable|integer',
                'display'      => 'required|integer',
                'active'       => 'required|integer',
            ]);

            $record->update($validated);

            return $this->sendResponse($record, 200, 'Developersocial updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Developersocial', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $record = Developersocial::find($id);
            if (!$record) return $this->sendError('Developersocial not found', 404);

            $record->active = !$record->active;
            $record->save();

            return $this->sendResponse([], 200, 'Developersocial visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function reorder(Request $request)
    {
        try {
            $data = $request->validate([
                '*.ds_id' => 'required|integer|exists:tbdevelopersocial,ds_id',
                '*.ds_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Developersocial::where('ds_id', $item['ds_id'])->update([
                    'ds_order' => $item['ds_order']
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Developersocial order updated successfully',
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to reorder Developersocial', 500, ['error' => $e->getMessage()]);
        }
    }
}
