<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendaftaranRoanMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        $kategori = $this->data['kategori'] ?? 'Roan';
        $subjek = ($kategori === 'Relawan')
            ? 'Konfirmasi Pendaftaran Relawan Banjir'
            : 'Konfirmasi Pendaftaran Roan Bersih Pantai';

        return new Envelope(subject: $subjek);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pendaftaran_sukses',
            with: [
                'name'     => $this->data['name'],
                'judul'    => $this->data['judul'],
                'tgl'      => $this->data['tgl'],
                'pj'       => $this->data['pj'] ?? '-',
            ],
        );
    }
}
