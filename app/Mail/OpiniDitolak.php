<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OpiniDitolak extends Mailable
{
    use Queueable, SerializesModels;

    public $opini;
    public $alasan;

    public function __construct($opini, $alasan)
    {
        $this->opini = $opini;
        $this->alasan = $alasan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Informasi Status Pengajuan Opini',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.opini_ditolak',
            with: [
                'opini' => $this->opini,
                'alasan' => $this->alasan,
            ],
        );
    }
}
