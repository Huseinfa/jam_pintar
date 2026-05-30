<?php

namespace App\Mail;

use App\Models\FeedbackInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FeedbackReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public FeedbackInvitation $invitation)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                config('mail.from.address') ?? 'noreply@jampintar.com',
                config('mail.from.name') ?? 'Jam Pintar'
            ),
            subject: 'Ingatkan: Feedback Anda Sangat Berarti untuk Kami!',
        );
    }

    public function content(): Content
    {
        $feedbackUrl = route('feedback.form', ['token' => $this->invitation->token]);

        return new Content(
            view: 'emails.feedback-reminder',
            with: [
                'user' => $this->invitation->user,
                'feedbackUrl' => $feedbackUrl,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
