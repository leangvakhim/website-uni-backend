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
            $data = $this->service->create($request->validated());
            return $this->sendResponse($data, 201, 'Contact created');
        } catch (Exception $e) {
            return $this->sendError('Create failed', 500, ['error' => $e->getMessage()]);
        }
    }

    public function update(ContactRequest $request, $id)
    {
        try {
            $contact = Contact::find($id);
            if (!$contact) return $this->sendError('Not found', 404);
            $updated = $this->service->update($contact, $request->validated());
            return $this->sendResponse($updated, 200, 'Updated');
        } catch (Exception $e) {
            return $this->sendError('Update failed', 500, ['error' => $e->getMessage()]);
        }
    }
}
