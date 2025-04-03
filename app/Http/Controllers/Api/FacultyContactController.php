<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\FacultyContact;
use App\Services\FacultyContactService;
use App\Http\Requests\FacultyContactRequest;
use Exception;

class FacultyContactController extends Controller
{
    protected $facultyContactService;

    public function __construct(FacultyContactService $facultyContactService)
    {
        $this->facultyContactService = $facultyContactService;
    }

    public function index()
    {
        try {
            $data = FacultyContact::with(['faculty'])->where('active', 1)->get();
            return $this->sendResponse($data->count() === 1 ? $data->first() : $data);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve contacts', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $contact = FacultyContact::with(['faculty'])->find($id);
            if (!$contact) return $this->sendError('Faculty contact not found', 404);
            return $this->sendResponse($contact);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve contact', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(FacultyContactRequest $request)
    {
        try {
            $created = $this->facultyContactService->create($request->validated());
            $created->load('faculty');
    
            return $this->sendResponse($created, 201, 'Faculty contact created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create contact', 500, ['error' => $e->getMessage()]);
        }
    }
    

    public function update(Request $request, $id)
    {
        try {
            $info = FacultyContact::find($id);
            if (!$info) return $this->sendError('Faculty contact not found', 404);
    
            $updated = $this->facultyContactService->update($info, $request->all());
            $updated->load('faculty');
    
            return $this->sendResponse($updated, 200, 'Faculty contact updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update faculty contact', 500, ['error' => $e->getMessage()]);
        }
    }
    

    public function visibility($id)
    {
        try {
            $contact = FacultyContact::find($id);
            if (!$contact) return $this->sendError('Faculty contact not found', 404);
            $contact->active = $contact->active ? 0 : 1;
            $contact->save();
            return $this->sendResponse([], 200, 'Visibility updated');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
