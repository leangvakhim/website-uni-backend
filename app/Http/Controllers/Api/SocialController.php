<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\SocialRequest;
use App\Models\Social;
use App\Services\SocialService;
use Exception;
use Illuminate\Http\Request;

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
            $social = $this->socialService->create($validated);
            return $this->sendResponse($social, 201, 'Social created successfully');
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
}
