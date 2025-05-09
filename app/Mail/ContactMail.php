<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ContactMail extends Mailable
{
    // use Queueable, SerializesModels;

    // /**
    //  * Create a new message instance.
    //  */

    // /**
    //  * Get the message envelope.
    //  */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Contact Mail',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }

    use Queueable, SerializesModels;

    public $data;

    // public function __construct($data)
    // {
    //     // Convert model to array if needed
    //     if ($data instanceof \Illuminate\Database\Eloquent\Model) {
    //         $this->data = $data->toArray();
    //     } else {
    //         $this->data = $data;
    //     }

    //     Log::info('✅ ContactMail received:', $this->data);
    // }

    // public function build()
    // {
    //     Log::info('✅ Building email with:', $this->data ?? ['data' => 'EMPTY']);

    //     if (!isset($this->data['m_firstname'])) {
    //         Log::error('🚨 first_name missing in ContactMail!');
    //     }

    //     return $this->from($this->data['m_email'], $this->data['m_firstname'] . ' ' . $this->data['m_lastname'])
    //         ->to(config('mail.dynamic_recipient'))
    //         ->subject('New Contact Message')
    //         ->view('emails.contact')
    //         ->with('data', $this->data);
    // }
}
