<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class YesterdayCashReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public Carbon $date;
    public string $filePath;
    public int $totalPayments;
    public float $totalAmount;

    /**
     * Create a new message instance.
     */
    public function __construct(Carbon $date, string $filePath, int $totalPayments, float $totalAmount)
    {
        $this->date = $date;
        $this->filePath = $filePath;
        $this->totalPayments = $totalPayments;
        $this->totalAmount = $totalAmount;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reporte de Pagos en Efectivo - ' . $this->date->format('d/m/Y'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.yesterday-cash-report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (file_exists(storage_path('app/public/' . $this->filePath))) {
            return [
                Attachment::fromPath(storage_path('app/public/' . $this->filePath))
                    ->as('Reporte_Pagos_Efectivo_' . $this->date->format('Y-m-d') . '.pdf')
                    ->withMime('application/pdf'),
            ];
        }

        return [];
    }
}