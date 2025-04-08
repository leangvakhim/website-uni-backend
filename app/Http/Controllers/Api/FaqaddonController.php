<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Faqaddon;
use App\Services\FaqaddonService;
use App\Http\Requests\FaqaddonRequest;
use Illuminate\Http\Request;
use Exception;

class FaqaddonController extends Controller
{
    protected $faqaddonService;

    public function __construct(FaqaddonService $faqaddonService)
    {
        $this->faqaddonService = $faqaddonService;
    }

    public function index()
    {
        try {
            $data = Faqaddon::with('faq')->where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch FAQ Addons', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $data = Faqaddon::with('faq')->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('FAQ Addon not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching FAQ Addon', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(FaqaddonRequest $request)
    {
        try {
            $data = $request->validated();

            if (!isset($data['fa_order'])) {
                $data['fa_order'] = Faqaddon::max('fa_order') + 1;
            }

            $created = app(FaqaddonService::class)->create($data);
            return $this->sendResponse($created, 201, 'FAQ Addon created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create FAQ Addon', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $addon = Faqaddon::find($id);
            if (!$addon) return $this->sendError('FAQ Addon not found', 404);

            $updated = $this->faqaddonService->update($addon, $request->all());
            $updated->load('faq');
            return $this->sendResponse($updated, 200, 'FAQ Addon updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update FAQ Addon', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $addon = Faqaddon::find($id);
            if (!$addon) return $this->sendError('FAQ Addon not found', 404);

            $addon->active = !$addon->active;
            $addon->save();

            return $this->sendResponse([], 200, 'FAQ Addon visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
