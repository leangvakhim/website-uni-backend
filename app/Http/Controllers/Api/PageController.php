<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\PageRequest;
use App\Models\Menu;
use App\Models\Page;
use App\Services\PageService;
use Exception;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index()
    {
        try {
            $data = Page::with(['menu'])->where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch pages', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $data = Page::with(['menu'])->find($id);
            return $data ? $this->sendResponse($data) : $this->sendError('Page not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error fetching page', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(PageRequest $request)
    {
        try {
            $validated = $request->validated();

            $menu = null;
            if (isset($validated['menu_id'])) {
                $menu = Menu::find($validated['menu_id']);
                if (!$menu) {
                    return $this->sendError('Menu not found', 404);
                }
            }

            $data = collect($validated)->except(['menu_id'])->toArray();
            $page = new Page($data);
            $page->p_title = $validated['p_title'] ?? null;
            $page->p_alias = $validated['p_alias'] ?? null;
            $page->p_busy = $validated['p_busy'] ?? 0;
            $page->display = $validated['display'] ?? 0;
            $page->active = $validated['active'] ?? 1;
            $page->save();

            return $this->sendResponse($page, 201, 'Page created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create page', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(PageRequest $request, $id)
    {
        try {
            $page = Page::find($id);
            if (!$page) return $this->sendError('Page not found', 404);

            $validated = $request->validated();

            unset($validated['p_menu']);

            $page->p_title = $validated['p_title'] ?? $page->p_title;
            $page->p_alias = $validated['p_alias'] ?? $page->p_alias;
            $page->p_busy = $validated['p_busy'] ?? $page->p_busy;
            $page->display = $validated['display'] ?? $page->display;
            $page->active = $validated['active'] ?? $page->active;

            if (isset($validated['menu_id'])) {
                $page->menu_id = $validated['menu_id'];
            }

            if ($page->isDirty()) {
                $page->save();
                return $this->sendResponse($page, 200, 'Page updated successfully');
            } else {
                return $this->sendError('No changes detected', 422);
            }
        } catch (Exception $e) {
            return $this->sendError('Failed to update page', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $page = Page::find($id);
            if (!$page) return $this->sendError('Page not found', 404);

            $page->active = !$page->active;
            $page->save();
            return $this->sendResponse([], 200, 'Page visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to toggle visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    public function duplicate($id)
    {
        $page = Page::find($id);

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $newPage = $page->replicate();
        $newPage->p_title = $page->p_title . ' (Copy)';
        $newPage->save();

        return response()->json(['message' => 'Page duplicated', 'data' => $newPage], 200);
    }

    public function updatePageMenu(PageRequest $request, $id)
    {
        try {
            $page = Page::find($id);
            if (!$page) {
                return $this->sendError('Page not found', 404);
            }

            $validated = $request->validated();

            if (!isset($validated['p_menu'])) {
                return $this->sendError('The p_menu field is required.', 422);
            }

            $page->p_menu = $validated['p_menu'];
            $page->save();

            return $this->sendResponse($page, 200, 'Page menu updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update page menu', 500, ['error' => $e->getMessage()]);
        }
    }
}
