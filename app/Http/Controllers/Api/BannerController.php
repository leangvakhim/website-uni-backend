<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Banner;
use App\Http\Requests\BannerRequest;
use App\Services\BannerService;
use Exception;

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
            $createdBanners = [];

            if (isset($validated['banners']) && is_array($validated['banners'])) {
                foreach ($validated['banners'] as $item) {

                    $item['title'] = $item['title'] ?? null;
                    $item['subtitle'] = $item['title'] ?? null;

                    $createdBanners[] = Banner::create($item);
                }
            }

            return $this->sendResponse($createdBanners, 201, 'Banner records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create banner', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(BannerRequest $request, $id)
    {
        try {
            $banner = Banner::find($id);
            if (!$banner) return $this->sendError('Banner not found', 404);

            $updated = $this->service->update($banner, $request->validated());
            return $this->sendResponse($updated, 200, 'Banner updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }

    // public function bannerGetBySection($sec_id)
    // {
    //     $banners = Banner::where('ban_sec', $sec_id)
    //         ->where('active', 1)
    //         ->get();

    //     return response()->json(['data' => $banners]);
    // }
}
