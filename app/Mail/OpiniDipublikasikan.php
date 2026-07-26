<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OpiniDipublikasikan extends Mailable
{
    use Queueable, SerializesModels;

    public $opini;

    public function __construct($opini)
    {
        $this->opini = $opini;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat! Opini Anda Telah Dipublikasikan',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.opini_dipublikasikan',
            with: [
                'opini' => $this->opini,
            ],
        );
    }
}
