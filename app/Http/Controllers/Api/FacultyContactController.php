<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\FacultyContact;
use App\Services\FacultyContactService;
use App\Http\Requests\FacultyContactRequest;
use App\Models\Faculty;
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
            $validated = $request->validated();
            $createdContacts = [];
    
            if (!isset($validated['f_id'])) {
                return $this->sendError('Faculty ID (fc_f) is required', 422);
            }
    
            $faculty = Faculty::find($validated['f_id']);
            if (!$faculty) {
                return $this->sendError('Faculty not found', 404);
            }
    
            if (isset($validated['faculty_contact']) && is_array($validated['faculty_contact'])) {
                foreach ($validated['faculty_contact'] as $item) {
                    $item['fc_f'] = $faculty->f_id;
    
                    if (!isset($item['fc_order'])) {
                        $item['fc_order'] = (FacultyContact::where('fc_f', $faculty->f_id)->max('fc_order') ?? 0) + 1;
                    }
    
                    $item['display'] = $item['display'] ?? 1;
                    $item['active'] = $item['active'] ?? 1;
    
                    $createdContacts[] = FacultyContact::create($item);
                }
            }
    
            return $this->sendResponse($createdContacts, 201, 'Faculty contact records created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create faculty contacts', 500, ['error' => $e->getMessage()]);
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

    public function getByFaculty($f_id)
    {
        $contact = FacultyContact::where('fc_f', $f_id)
            ->where('active', 1)
            ->orderBy('fc_order')
            ->get();

        return response()->json(['data' => $contact]);
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            '*.fc_id' => 'required|integer|exists:tbfaculty_contact,fc_id',
            '*.fc_order' => 'required|integer'
        ]);

        foreach ($data as $item) {
            FacultyContact::where('fc_id', $item['fc_id'])->update(['fc_order' => $item['fc_order']]);
        }
        return response()->json([
            'message' => 'FacultyContact order updated successfully',
        ], 200);
    }
}