<?php

namespace App\Mail;

use App\Models\ManeuverPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class NewPaymentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public ManeuverPayment $payment;

    /**
     * Create a new message instance.
     */
    public function __construct(ManeuverPayment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Acoman - Nuevo Pago Registrado - Maniobra #' . $this->payment->maneuver_id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'emails.new-payment-notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        
        // Agregar comprobante de pago si existe
        if ($this->payment->payment_file && Storage::disk('public')->exists($this->payment->payment_file)) {
            $filePath = Storage::disk('public')->path($this->payment->payment_file);
            $fileName = 'Comprobante_Pago_Maniobra_' . $this->payment->maneuver_id . '_' . pathinfo($this->payment->payment_file, PATHINFO_EXTENSION);
            
            $attachments[] = Attachment::fromPath($filePath)
                ->as($fileName)
                ->withMime($this->getMimeType($this->payment->payment_file));
        }
        
        return $attachments;
    }
    
    /**
     * Get the MIME type based on file extension.
     */
    private function getMimeType(string $filePath): string
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        
        return match ($extension) {
            'pdf' => 'application/pdf',
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            default => 'application/octet-stream',
        };
    }
}