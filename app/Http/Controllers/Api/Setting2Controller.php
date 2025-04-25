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
            $items = Setting2::all();
            return $this->sendResponse($items->count() === 1 ? $items->first() : $items);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch records', 500, ['error' => $e->getMessage()]);
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

    // public function create(Setting2Request $request)
    // {
    //     try {
    //         $validated = $request->validated();
    //         $createdSetting2 = [];

    //         if (isset($validated['about']) && is_array($validated['about'])) {
    //             foreach ($validated['about'] as $item) {

    //                 $item['set_facultytitle'] = $item['set_facultytitle'] ?? null;
    //                 $item['set_facultydep'] = $item['set_facultydep'] ?? null;
    //                 $item['set_logo'] = $item['set_logo'] ?? null;
    //                 $item['set_amstu'] = $item['set_amstu'] ?? null;
    //                 $item['set_enroll'] = $item['set_enroll'] ?? null;
    //                 $item['lang'] = $item['lang'] ?? null;

    //                 $createdSetting2[] = Setting2::create($item);
    //             }
    //         }

    //         return $this->sendResponse($createdSetting2, 201, 'Setting records created successfully');
    //     } catch (Exception $e) {
    //         return $this->sendError('Failed to create setting', 500, ['error' => $e->getMessage()]);
    //     }
    // }

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

    // public function update(Setting2Request $request, $id)
    // {
    //     try {
    //         $set2 = Setting2::find($id);
    //         if (!$set2) {
    //             return $this->sendError('Setting2 not found', 404);
    //         }

    //         $request->merge($request->input('about'));

    //         $validated = $request->validate([
    //             'set_facultytitle' => 'nullable|string|max:50',
    //             'set_facultydep' => 'nullable|string|max:50',
    //             'set_logo' => 'nullable|integer|exists:tbimage,image_id',
    //             'set_amstu' => 'nullable|numeric',
    //             'set_enroll' => 'nullable|numeric',
    //             'lang' => 'nullable|integer|in:1,2',
    //         ]);

    //         $set2->update($validated);

    //         return $this->sendResponse($set2, 200, 'Setting updated successfully');
    //     } catch (Exception $e) {
    //         return $this->sendError('Failed to update setting', 500, ['error' => $e->getMessage()]);
    //     }
    // }

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
