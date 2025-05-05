<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Email;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\EmailRequest;
use Exception;

class EmailController extends Controller
{
    public function index()
    {
        try {
            // No relation like 'img' in tbemail, so just fetching where active = 1
            $emails = Email::where('m_active', 1)->get();
            return $this->sendResponse($emails->count() === 1 ? $emails->first() : $emails);
        } catch (Exception $e) {
            return $this->sendError('Failed to fetch emails', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $email = Email::find($id);
            if (!$email) {
                return $this->sendError('Email not found', 404);
            }
            return $this->sendResponse($email);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve email', 500, $e->getMessage());
        }
    }

    public function create(EmailRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $email = Email::create($validatedData);
            return $this->sendResponse($email, 201, 'Email created successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to create email', 500, $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $email = Email::find($id);
            if (!$email) {
                return $this->sendError('Email not found', 404);
            }
            $email->update($request->all());
            return $this->sendResponse($email, 200, 'Email updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update email', 500, $e->getMessage());
        }
    }

    public function visibility($id)
    {
        try {
            $email = Email::find($id);
            if (!$email) return $this->sendError('Email not found', 404);

            $email->m_active = $email->m_active ? 0 : 1;
            $email->save();

            return $this->sendResponse([], 200, 'Visibility toggled');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }
}
