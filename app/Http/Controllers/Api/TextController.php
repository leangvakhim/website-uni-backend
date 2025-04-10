<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller; 
use Illuminate\Http\Request;
use App\Models\Text;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\TextRequest;
use Exception;

class TextController extends Controller
{
    public function index()
    {
        try {
            $texts = Text::all();
            return $this->sendResponse($texts);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve texts', 500, $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $text = Text::find($id);
            if (!$text) {
                return $this->sendError('Text not found', 404);
            }
            return $this->sendResponse($text);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve text', 500, $e->getMessage());
        }
    }

    public function create(TextRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdTexts = [];

            if (isset($validated['texts']) && is_array($validated['texts'])) {
                foreach ($validated['texts'] as $item) {

                    $item['title'] = $item['title'] ?? null;
                    $item['desc'] = $item['desc'] ?? null;
                    $item['type'] = $item['type'] ?? null;
                    $item['tag'] = $item['tag'] ?? null;
                    $item['lang'] = $item['lang'] ?? null;

                    $createdTexts[] = Text::create($item);
                }
            }

            return $this->sendResponse($createdTexts, 201, 'Text records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create text', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $text = Text::find($id);
            if (!$text) {
                return $this->sendError('Text not found', 404);
            }
            $text->update($request->all());
            return $this->sendResponse($text, 200, 'Text updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update text', 500, $e->getMessage());
        }
    }

}
