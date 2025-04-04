<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\PageRequest;
use App\Models\Page;
use App\Services\PageService;
use Exception;

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
            $data = $request->validated();

            $page = app(PageService::class)->create($data);

            return $this->sendResponse($page, 201, 'Page created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create page', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(PageRequest $request, $id)
    {
        try {
            $page = Page::find($id);
            if (!$page) return $this->sendError('Page not found', 404);

            $updated = $this->pageService->update($page, $request->validated());
            return $this->sendResponse($updated, 200, 'Page updated successfully');
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
}
