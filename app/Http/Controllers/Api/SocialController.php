<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\SocialRequest;
use App\Models\Faculty;
use App\Models\Social;
use App\Services\SocialService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class SocialController extends Controller
{
    protected $socialService;

    public function __construct(SocialService $socialService)
    {
        $this->socialService = $socialService;
    }

    public function index()
    {
        try {
            $socials = Social::with([
                'faculty:f_id,f_name,f_position,f_portfolio,f_img,f_order,lang,display,active',
                'img:image_id,img'
            ])->where('active', 1)->get();

            return $this->sendResponse($socials);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve socials', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $social = Social::with(['faculty', 'img'])->find($id);
            if (!$social) {
                return $this->sendError('Social not found', 404);
            }

            return $this->sendResponse($social);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve social', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(SocialRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdSocials = [];

            // Ensure f_id is provided
            if (!isset($validated['f_id'])) {
                return $this->sendError('Faculty ID is required', 422);
            }

            $faculty = Faculty::find($validated['f_id']);
            if (!$faculty) {
                return $this->sendError('Faculty not found', 404);
            }

            if (isset($validated['social_faculty']) && is_array($validated['social_faculty'])) {
                foreach ($validated['social_faculty'] as $item) {
                    $item['social_faculty'] = $faculty->f_id;

                    if (!isset($item['social_order'])) {
                        // $item['social_order'] = Social::max('social_order') + 1;
                        $item['social_order'] = (Social::where('social_faculty', $faculty->f_id)->max('social_order') ?? 0) + 1;
                    }

                    $item['display'] = $item['display'] ?? 1;
                    $item['active'] = $item['active'] ?? 1;

                    $createdSocials[] = Social::create($item);
                }
            }

            return $this->sendResponse($createdSocials, 201, 'Social records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create social', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $social = Social::find($id);
            if (!$social) {
                return $this->sendError('Social not found', 404);
            }

            $updated = $this->socialService->update($social, $request->all());
            return $this->sendResponse($updated, 200, 'Social updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update social', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $social = Social::find($id);
            if (!$social) {
                return $this->sendError('Social not found', 404);
            }

            $social->active = $social->active ? 0 : 1;
            $social->save();

            return $this->sendResponse([], 200, 'Social visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function getByFaculty($f_id)
    {
        $socials = Social::where('social_faculty', $f_id)
            ->where('active', 1)
            ->orderBy('social_order')
            ->get();

        return response()->json(['data' => $socials]);
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            '*.social_id' => 'required|integer|exists:tbsocial,social_id',
            '*.social_order' => 'required|integer'
        ]);

        foreach ($data as $item) {
            Social::where('social_id', $item['social_id'])->update(['social_order' => $item['social_order']]);
        }

        return response()->json([
            'message' => 'Social order updated successfully',
        ], 200);
    }
}
