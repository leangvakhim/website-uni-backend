<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Banner;
use App\Http\Requests\BannerRequest;
use App\Services\BannerService;
use Exception;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    protected $service;

    public function __construct(BannerService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Banner::with(['section', 'image'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load banners', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $banner = Banner::with(['section', 'image'])->find($id);
            if (!$banner) {
                return $this->sendError('Banner not found', 404);
            }
            return $this->sendResponse($banner);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve banner', 500, ['error' => $e->getMessage()]);
        }
    }

    public function store(BannerRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdBanner = [];

            if (isset($validated['banners']) && is_array($validated['banners'])) {
                foreach ($validated['banners'] as $item) {

                    $item['ban_title'] = $item['ban_title'] ?? null;
                    $item['ban_subtitle'] = $item['ban_subtitle'] ?? null;
                    $item['ban_img'] = $item['ban_img'] ?? null;

                    if (!empty($item['ban_id'])) {
                        // Update existing
                        $existing = Banner::find($item['ban_id']);
                        if ($existing) {
                            $existing->update([
                                'ban_title' => $item['ban_title'],
                                'ban_subtitle' => $item['ban_subtitle'],
                                'ban_img' => $item['ban_img'],
                            ]);
                            $createdBanner[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = Banner::where('ban_sec', $item['ban_sec'])
                            ->first();

                        if (!$existing) {
                            $createdRecord = Banner::create($item);
                            $createdBanner[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdBanner, 201, 'Banner records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update Banner', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(BannerRequest $request, $id)
    {
        try {
            $Banner = Banner::find($id);
            if (!$Banner) {
                return $this->sendError('Banner not found', 404);
            }

            $data = $request->input('banners');

            $validated = validator($data, [
                'ban_title' => 'nullable|string',
                'ban_subtitle' => 'nullable|string',
                'ban_img' => 'nullable|integer',
                'ban_sec' => 'nullable|integer',
            ])->validate();

            $Banner->update($validated);

            return $this->sendResponse($Banner, 200, 'Banner updated successfully');
            return $this->sendResponse([], 200, 'Banner updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Banner', 500, ['error' => $e->getMessage()]);
        }
    }
}
