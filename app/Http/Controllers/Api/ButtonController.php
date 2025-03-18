<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Button;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ButtonRequest;
use Exception;

class ButtonController extends Controller
{
    public function index()
    {
        try {
            $buttons = Button::all();
            return $this->sendResponse($buttons);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve buttons', 500, $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $button = Button::find($id);
            if (!$button) {
                return $this->sendError('Button not found', 404);
            }
            return $this->sendResponse($button);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve button', 500, $e->getMessage());
        }
    }

    public function create(ButtonRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $button = Button::create($validatedData);
            return $this->sendResponse($button, 201, 'Button created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create button', 500, $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $button = Button::find($id);
            if (!$button) {
                return $this->sendError('Button not found', 404);
            }
            $button->update($request->all());
            return $this->sendResponse($button, 200, 'Button updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update button', 500, $e->getMessage());
        }
    }
}
