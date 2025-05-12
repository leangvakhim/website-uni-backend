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
            $validated = $request->validated();
            $createdText = [];

            if (isset($validated['texts']) && is_array($validated['texts'])) {
                foreach ($validated['texts'] as $item) {

                    $item['title'] = $item['title'] ?? null;
                    $item['desc'] = $item['desc'] ?? null;
                    $item['text_type'] = $item['text_type'] ?? null;
                    $item['text_sec'] = $item['text_sec'] ?? null;
                    $item['tag'] = null;
                    $item['lang'] = null;

                    if (!empty($item['text_id'])) {
                        // Update existing
                        $existing = Text::find($item['text_id']);
                        if ($existing) {
                            $existing->update([
                                'title' => $item['title'],
                                'desc' => $item['desc'],
                                'text_type' => $item['text_type'],
                                'text_sec' => $item['text_sec'],
                                'tag' => null,
                                'lang' => null,
                            ]);
                            $createdText[] = $existing;
                        }
                    } else {
                        // Prevent duplicate entries by checking for existing combination
                        $existing = Text::where('text_sec', $item['text_sec'])
                            ->first();

                        if ($existing) {
                            $createdText[] = $existing;
                        } else {
                            $createdRecord = Text::create($item);
                            $createdText[] = $createdRecord;
                        }
                    }
                }
            }

            return $this->sendResponse($createdText, 201, 'Text records created/updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create/update Text', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(TextRequest $request, $id)
    {
        try {
            $Text = Text::find($id);
            if (!$Text) {
                return $this->sendError('Text not found', 404);
            }

            $data = $request->input('texts');

            $validated = validator($data, [
                'title' => 'nullable|string',
                'desc' => 'nullable|string',
                'text_type' => 'nullable|integer',
                'text_sec' => 'nullable|integer'
            ])->validate();

            $Text->update($validated);

            return $this->sendResponse($Text, 200, 'Text updated successfully');
            return $this->sendResponse([], 200, 'Text updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Text', 500, ['error' => $e->getMessage()]);
        }
    }
}
