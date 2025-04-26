<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\SettingsocialRequest;
use App\Models\Settingsocial;
use App\Models\Setting2;
use Illuminate\Http\Request;
use Exception;

class SettingsocialController extends Controller
{
    public function index()
    {
        try {
            $records = Settingsocial::with(['img', 'setting'])
            ->where('active', 1)
            ->orderBy('setsoc_order', 'asc')
            ->get();
            return $this->sendResponse($records);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch records', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $record = Settingsocial::with(['img', 'setting'])->find($id);
            return $record ? $this->sendResponse($record) : $this->sendError('Data not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch data', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(SettingsocialRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdSocials = [];

            if (isset($validated['setting_social']) && is_array($validated['setting_social'])) {
                foreach ($validated['setting_social'] as $item) {

                    if (!isset($item['setsoc_order'])) {
                        $item['setsoc_order'] = (Settingsocial::max('setsoc_order') ?? 0) + 1;
                    }

                    $item['display'] = $item['display'] ?? 1;
                    $item['active'] = $item['active'] ?? 1;

                    $createdSocials[] = Settingsocial::create($item);
                }
            }

            return $this->sendResponse($createdSocials, 201, 'Socials created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create socials', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(SettingsocialRequest $request, $id)
    {
        try {
            $settingsocial = Settingsocial::find($id);
            if (!$settingsocial) {
                return $this->sendError('Settingsocial not found', 404);
            }

            $request->merge($request->input('setting_social'));

            $validated = $request->validate([
                'setsoc_title' => 'required|string',
                'setsoc_link' => 'nullable|string',
                'setsoc_img' => 'nullable|integer',
                'display' => 'nullable|integer',
            ]);

            $settingsocial->update($validated);

            return $this->sendResponse($settingsocial, 200, 'settingsocial updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update settingsocial', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $record = Settingsocial::find($id);
            if (!$record) {
                return $this->sendError('Record not found', 404);
            }

            $record->active = !$record->active;
            $record->save();

            return $this->sendResponse([], 200, 'Visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function duplicate($id)
    {
        try {
            $record = Settingsocial::find($id);
            if (!$record) return $this->sendError('Record not found', 404);

            $newRecord = $record->replicate();
            $newRecord->setsoc_title = $record->setsoc_title . ' (Copy)';
            $newRecord->setsoc_order = (Settingsocial::max('setsoc_order') ?? 0) + 1;
            $newRecord->save();

            return $this->sendResponse($newRecord, 201, 'Record duplicated');
        } catch (Exception $e) {
            return $this->sendError('Failed to duplicate', 500, ['error' => $e->getMessage()]);
        }
    }

    public function reorder(Request $request)
    {
        try {
            $data = $request->validate([
                '*.setsoc_id' => 'required|integer|exists:tbsettingsocial,setsoc_id',
                '*.setsoc_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Settingsocial::where('setsoc_id', $item['setsoc_id'])->update([
                    'setsoc_order' => $item['setsoc_order']
                ]);
            }

            return $this->sendResponse([], 200, 'Settingsocial reordered successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update reorder', 500, ['error' => $e->getMessage()]);
        }
    }

}
