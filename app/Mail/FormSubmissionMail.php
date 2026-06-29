<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $formType;
    public $title;
    public $formData;
    public $submittedAt;

    /**
     * Create a new message instance.
     */
    public function __construct(string $formType, string $title, array $formData, ?string $submittedAt = null)
    {
        $this->formType = $formType;
        $this->title = $title;
        $this->formData = $formData;
        $this->submittedAt = $submittedAt ?? now()->format('F j, Y \a\t g:i A');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->title . ' - The Sprout Academy',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.form-submission',
            with: [
                'formType' => $this->formType,
                'title' => $this->title,
                'formData' => $this->formData,
                'submittedAt' => $this->submittedAt,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
