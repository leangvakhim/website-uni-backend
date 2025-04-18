<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Faqaddon;
use App\Services\FaqaddonService;
use App\Http\Requests\FaqaddonRequest;
use App\Models\Faq;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

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
            $data = Faqaddon::with('faq')
                ->where('active', 1)
                ->orderBy('fa_order', 'asc')
                ->get();
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
            $validated = $request->validated();
            $faqaddons = $validated['faqaddon'] ?? [];

            if (empty($faqaddons)) {
                return $this->sendError('No faqs Data Provided', 422);
            }

            $createdfaqaddons = [];

            foreach ($faqaddons as $item) {
                if (!isset($item['fa_faq'])) {
                    return $this->sendError('faq ID is required', 422);
                }

                $item['fa_order'] = (Faqaddon::where('fa_faq', $item['fa_faq'])->max('fa_order') ?? 0) + 1;

                $item['fa_question'] = $item['fa_question'] ?? null;
                $item['fa_answer'] = $item['fa_answer'] ?? null;
                $item['display'] = $item['display'] ?? 1;
                $item['active'] = $item['active'] ?? 1;

                $faqaddons = Faqaddon::create($item);
                $createdfaqaddons[] = $faqaddons;
            }

            return $this->sendResponse($createdfaqaddons, 201, 'Faqaddon created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create Faqaddon', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(FaqaddonRequest $request, $id)
    {
        try {

            $faqaddon = Faqaddon::find($id);
            if (!$faqaddon) {
                return $this->sendError('faq not found', 404);
            }

            $faqaddonData = $request->input('faqaddon');
            if (!$faqaddonData || !is_array($faqaddonData)) {
                return $this->sendError('Invalid faqaddon data provided', 422);
            }
            $request->merge($faqaddonData);

            $validated = $request->validate([
                'fa_question' => 'nullable|string',
                'fa_answer' => 'nullable|string',
                'fa_faq' => 'nullable|integer',
                'display' => 'nullable|integer',
            ]);

            $faqaddon->update($validated);

            return $this->sendResponse($faqaddon, 200, 'faqaddon updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update faqaddon', 500, ['error' => $e->getMessage()]);
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
    public function reorder(Request $request)
    {
        try {
            $data = $request->validate([
                '*.fa_id' => 'required|integer|exists:tbfaqaddon,fa_id',
                '*.fa_order' => 'required|integer'
            ]);

            foreach ($data as $item) {
                Faqaddon::where('fa_id', $item['fa_id'])->update([
                    'fa_order' => $item['fa_order']
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Faqaddon order updated successfully',
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to reorder faqaddon', 500, ['error' => $e->getMessage()]);
        }
    }
}
