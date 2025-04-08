<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Intro;
use App\Http\Requests\IntroRequest;
use App\Services\IntroService;
use Exception;

class IntroController extends Controller
{
    protected $service;

    public function __construct(IntroService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Intro::with(['section', 'image'])->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to load Intro data', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $intro = Intro::with(['section', 'image'])->find($id);
            if (!$intro) {
                return $this->sendError('Intro not found', 404);
            }
            return $this->sendResponse($intro);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve Intro', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(IntroRequest $request)
    {
        try {
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'Intro created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(IntroRequest $request, $id)
    {
        try {
            $intro = Intro::find($id);
            if (!$intro) return $this->sendError('Not found', 404);
            $updated = $this->service->update($intro, $request->validated());
            return $this->sendResponse($updated, 200, 'Updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
