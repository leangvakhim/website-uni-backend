<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Setting2;
use App\Http\Requests\Setting2Request;
use Exception;
use Illuminate\Http\Request;

class Setting2Controller extends Controller
{
    public function index()
    {
        try {
            $items = Setting2::with(['logo'])->get();
            return $this->sendResponse($items->count() === 1 ? $items->first() : $items);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch records', 500, ['error' => $e->getMessage()]);
        }
    }

    public function getByLang($lang)
    {
        try {
            $item = Setting2::with(['logo'])->where('lang', $lang)->first();
            if (!$item) {
                return $this->sendError('Setting2 with this language not found', 404);
            }
            return $this->sendResponse($item);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch setting by language', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $item = Setting2::find($id);
            return $item ? $this->sendResponse($item) : $this->sendError('Record not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(Setting2Request $request)
    {
        try {
            $validated = $request->validated();

            $item = [
                'set_facultytitle' => $validated['set_facultytitle'] ?? null,
                'set_facultydep' => $validated['set_facultydep'] ?? null,
                'set_logo' => $validated['set_logo'] ?? null,
                'set_amstu' => $validated['set_amstu'] ?? null,
                'set_enroll' => $validated['set_enroll'] ?? null,
                'set_baseurl' => $validated['set_baseurl'] ?? null,
                'lang' => $validated['lang'] ?? null,
            ];

            $createdSetting2 = Setting2::create($item);

            return $this->sendResponse($createdSetting2, 201, 'Setting record created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create setting', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(Setting2Request $request, $id)
    {
        try {
            $set2 = Setting2::find($id);
            if (!$set2) {
                return $this->sendError('Setting2 not found', 404);
            }

            $validated = $request->validated();

            $set2->update($validated);

            return $this->sendResponse($set2, 200, 'Setting updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update setting', 500, ['error' => $e->getMessage()]);
        }
    }

    public function duplicate($id)
    {
        try {
            $item = Setting2::find($id);
            if (!$item) return $this->sendError('Record not found', 404);

            $copy = $item->replicate();
            $copy->set_facultytitle = $copy->set_facultytitle . ' (Copy)';
            $copy->save();

            return $this->sendResponse($copy, 201, 'Record duplicated');
        } catch (Exception $e) {
            return $this->sendError('Failed to duplicate record', 500, ['error' => $e->getMessage()]);
        }
    }
}
