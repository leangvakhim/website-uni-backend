<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\News;
use App\Http\Requests\NewsRequest;
use Exception;

class NewsController extends Controller
{
    public function index()
    {
        try {
            $news = News::where('active', 1)->get();
            return $this->sendResponse($news->count() === 1 ? $news->first() : $news);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch news', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $news = News::find($id);
            if (!$news) return $this->sendError('News not found', 404);
            return $this->sendResponse($news);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch news', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(NewsRequest $request)
    {
        try {
            $news = News::create($request->validated());
            return $this->sendResponse($news, 201, 'News created');
        } catch (Exception $e) {
            return $this->sendError('Failed to create news', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(NewsRequest $request, $id)
    {
        try {
            $news = News::find($id);
            if (!$news) return $this->sendError('News not found', 404);
            $news->update($request->all());
            return $this->sendResponse($news, 200, 'News updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update news', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility($id)
    {
        try {
            $news = News::find($id);
            if (!$news) return $this->sendError('News not found', 404);
            $news->active = $news->active ? 0 : 1;
            $news->save();
            return $this->sendResponse([], 200, 'Visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
