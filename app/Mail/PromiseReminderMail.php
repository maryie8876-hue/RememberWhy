<?php

namespace App\Mail;

use App\Models\Promise;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PromiseReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Promise $promise)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Remember why you started.',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.promise_reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
