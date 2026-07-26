<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendaftaranRelawanMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Pendaftaran Relawan Banjir'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pendaftaran_relawan_sukses',
            with: [
                'name'        => $this->data['name'],
                'judul'       => $this->data['judul'],
                'tgl'         => $this->data['tgl'],
                'koordinator' => $this->data['koordinator'] ?? '-',
            ],
        );
    }
}
