<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Social;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SocialRequest;
use Exception;

class SocialController extends Controller
{
    public function index()
    {
        try {
            $socials = Social::with([
                'img:image_id,img' 
            ])->where('active', 1)->get();

            return $this->sendResponse(
                $socials->count() === 1 ? $socials->first() : $socials
            );
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve social records', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $social = Social::with([
                'img:image_id,img' 
            ])->find($id);

            if (!$social) {
                return $this->sendError('Social record not found', 404);
            }

            return $this->sendResponse($social);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve social record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(SocialRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $social = Social::create($validatedData);
            return $this->sendResponse($social, 201, 'Social record created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create social record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(SocialRequest $request, $id)
    {
        try {
            $social = Social::find($id);
            if (!$social) {
                return $this->sendError('Social record not found', 404);
            }
            $social->update($request->all());
            return $this->sendResponse($social, 200, 'Social record updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update social record', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $social = Social::find($id);
            if (!$social) {
                return $this->sendError('Social record not found', 404);
            }
            $social->active = $social->active == 1 ? 0 : 1;
            $social->save();
            return $this->sendResponse([], 200, 'Social visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
