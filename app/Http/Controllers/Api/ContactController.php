<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Services\ContactService;
use Exception;

class ContactController extends Controller
{
    protected $service;

    public function __construct(ContactService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = Contact::with('subcontact')->get();
            return $this->sendResponse($data);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch contacts', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $contact = Contact::with('subcontact')->find($id);
            return $contact ? $this->sendResponse($contact) : $this->sendError('Contact not found', 404);
        } catch (Exception $e) {
            return $this->sendError('Error loading contact', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(ContactRequest $request)
    {
        try {
            $validated = $request->validated();
            $createdContact = [];

            if (isset($validated['contact']) && is_array($validated['contact'])) {
                foreach ($validated['contact'] as $item) {

                    $item['con_title'] = $item['con_title'] ?? null;
                    $item['con_subtitle'] = $item['con_subtitle'] ?? null;
                    $item['con_img'] = $item['con_img'] ?? null;
                    $item['con_addon'] = $item['con_addon'] ?? null;
                    $item['con_addon2'] = $item['con_addon2'] ?? null;
                    $item['con_addon3'] = $item['con_addon3'] ?? null;
                    $item['lang'] = $item['lang'] ?? null;

                    $createdContact[] = Contact::create($item);
                }
            }

            return $this->sendResponse($createdContact, 201, 'Contact records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create contact', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(ContactRequest $request, $id)
    {
        try {
            $contact = Contact::find($id);
            if (!$contact) {
                return $this->sendError('Contact not found', 404);
            }

            $request->merge($request->input('contact'));

            $validated = $request->validate([
                'con_title' => 'nullable|string|max:255',
                'con_subtitle' => 'nullable|string',
                'con_img' => 'nullable|integer|exists:tbimage,image_id',
                'con_addon' => 'nullable|integer|exists:tbsubcontact,scon_id',
                'con_addon2' => 'nullable|integer|exists:tbsubcontact,scon_id',
                'con_addon3' => 'nullable|integer|exists:tbsubcontact,scon_id',
                'lang' => 'nullable|integer',
            ]);

            $contact->update($validated);

            return $this->sendResponse($contact, 200, 'Contact updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Contact', 500, ['error' => $e->getMessage()]);
        }
    }
}
