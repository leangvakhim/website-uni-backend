<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Email;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\EmailRequest;
use App\Mail\ContactMail;
use App\Models\Setting2;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
            return $this->sendError('Failed to retrieve email', 500, ['error' => $e->getMessage()]);
        }
    }

    public function create(EmailRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $email = Email::create($validatedData);

            // 🔄 Get Telegram credentials from the settings table
            $setting = Setting2::first(); // adjust if you use whereLang or something else

            if ($setting && $setting->set_telegramtoken && $setting->set_chatid) {
                $this->sendTelegramMessage($validatedData, $setting->set_telegramtoken, $setting->set_chatid);
            }

            return $this->sendResponse($email, 201, 'Email created and Telegram notified');
        } catch (Exception $e) {
            return $this->sendError('Failed to create email', 500, ['error' => $e->getMessage()]);
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
            return $this->sendError('Failed to update email', 500, ['error' => $e->getMessage()]);
        }
    }

    public function visibility(Request $request)
    {
        try {
            $ids = $request->input('m_id');

            if (!is_array($ids)) {
                return $this->sendError('Invalid input. Array of IDs required.', 422);
            }

            $emails = Email::whereIn('m_id', $ids)->get();

            if ($emails->isEmpty()) {
                return $this->sendError('No matching emails found', 404);
            }

            foreach ($emails as $email) {
                $email->m_active = $email->m_active ? 0 : 1;
                $email->save();
            }

            return $this->sendResponse([], 200, 'Visibility toggled for selected emails');
        } catch (Exception $e) {
            return $this->sendError('Failed to update visibility', 500, ['error' => $e->getMessage()]);
        }
    }

    private function sendTelegramMessage(array $data, string $token, string $chatId): void
    {
        $message = "📬 New Message:\n"
            . "👤 Name: {$data['m_firstname']} {$data['m_lastname']}\n"
            . "📧 Email: {$data['m_email']}\n"
            . "📝 Message:\n{$data['m_description']}";

        \Illuminate\Support\Facades\Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }
}
