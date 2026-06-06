<?php

namespace App\Mail;

use App\Models\Result;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ResultMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Result $result,
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                config('mail.from.address') ?? 'noreply@jampintar.com',
                config('mail.from.name') ?? 'Jam Pintar'
            ),
            subject: 'Hasil Test Kamu Sudah Siap! [' . $this->result->id . ' - ' . now()->format('d/m/Y H:i:s') . ']',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.result',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (empty($this->result->pdf_path) || !Storage::disk('public')->exists($this->result->pdf_path)) {
            return [];
        }

        return [
            Attachment::fromPath(Storage::disk('public')->path($this->result->pdf_path))
                ->as(basename($this->result->pdf_path))
                ->withMime('application/pdf'),
        ];
    }
}
