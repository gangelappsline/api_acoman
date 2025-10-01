<?php

namespace App\Mail;

use App\Models\Maneuver;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewManeuverNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Maneuver $maneuver;

    /**
     * Create a new message instance.
     */
    public function __construct(Maneuver $maneuver)
    {
        $this->maneuver = $maneuver;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Acoman - Nueva Maniobra Registrada #' . $this->maneuver->id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'emails.new-maneuver-notification',
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