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

    public function getByLang($lang)
    {
        try {
            $item = Contact::with(['image:image_id,img'])
                ->with([
                    'subcontact1.image:image_id,img',
                    'subcontact2.image:image_id,img',
                    'subcontact3.image:image_id,img'
                ])
                ->where('lang', $lang)->first();
            if (!$item) {
                return $this->sendError('Contact with this language not found', 404);
            }
            return $this->sendResponse($item);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch setting by language', 500, ['error' => $e->getMessage()]);
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

            $contactData = [
                'con_title' => $validated['con_title'] ?? null,
                'con_subtitle' => $validated['con_subtitle'] ?? null,
                'con_img' => $validated['con_img'] ?? null,
                'con_addon' => $validated['con_addon'] ?? null,
                'con_addon2' => $validated['con_addon2'] ?? null,
                'con_addon3' => $validated['con_addon3'] ?? null,
                'lang' => $validated['lang'] ?? null,
            ];

            $createdContact = Contact::create($contactData);

            return $this->sendResponse($createdContact, 201, 'Contact record created successfully');
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

            $validated = $request->validated();

            $contactData = [
                'con_title' => $validated['con_title'] ?? null,
                'con_subtitle' => $validated['con_subtitle'] ?? null,
                'con_img' => $validated['con_img'] ?? null,
                'con_addon' => $validated['con_addon'] ?? null,
                'con_addon2' => $validated['con_addon2'] ?? null,
                'con_addon3' => $validated['con_addon3'] ?? null,
                'lang' => $validated['lang'] ?? null,
            ];

            $contact->update($contactData);

            return $this->sendResponse($contact, 200, 'Contact updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update Contact', 500, ['error' => $e->getMessage()]);
        }
    }
}
