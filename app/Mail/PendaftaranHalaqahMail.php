<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendaftaranHalaqahMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        // $data diharapkan berisi: ['name', 'judul', 'tgl', 'panitia_nama', 'panitia_telpon']
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Pendaftaran Halaqah'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pendaftaran_halaqah',
            with: [
                'name'           => $this->data['name'],
                'judul'          => $this->data['judul'],
                'tgl'            => $this->data['tgl'],
                'panitia_nama'   => $this->data['panitia_nama'],
                'panitia_telpon' => $this->data['panitia_telpon'],
            ],
        );
    }
}
