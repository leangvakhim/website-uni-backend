<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Text;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\TextRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class TextController extends Controller
{
    public function index()
    {
        try {
            $texts = Text::with('text_sec')->get();
            return $this->sendResponse($texts);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve texts', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $text = Text::with('text_sec')->find($id);
            if (!$text) {
                return $this->sendError('Text not found', 404);
            }
            return $this->sendResponse($text);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve text', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(TextRequest $request)
    {
        try {
            Log::info('📝 Creating Text Record - Payload:', $request->all());
            // Log::info('Text Create Payload:', $request);
            $validated = $request->validated();
            Log::info('Text Create Payload:', $validated);
            $createdTexts = [];

            if (isset($validated['texts']) && is_array($validated['texts'])) {
                foreach ($validated['texts'] as $item) {

                    $item['title'] = $item['title'] ?? null;
                    $item['desc'] = $item['desc'] ?? null;
                    $item['text_type'] = $item['text_type'] ?? null;
                    $item['text_sec'] = $item['text_sec'] ?? null;
                    $item['tag'] = null;
                    $item['lang'] = null;


                    $createdTexts[] = Text::create($item);
                }
            }
            Log::info('✅ Created Text Record:', $createdTexts);


            return $this->sendResponse($createdTexts, 201, 'Text records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create text', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(TextRequest $request, $id)
    {
        try {
            $text = Text::find($id);
            if (!$text) {
                return $this->sendError('Text not found', 404);
            }

            $request->merge($request->input('texts'));

            $validated = $request->validate([
                'title' => 'required|string',
                'desc' => 'nullable|string',
                'text_type' => 'nullable|integer',
                'text_sec' => 'nullable|integer'
            ]);

            $text->update($validated);

            return $this->sendResponse($text, 200, 'text updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update text', 500, ['error' => $e->getMessage()]);
        }
    }
}
