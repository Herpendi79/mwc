<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BencanaPublishedMail extends Mailable
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
            subject: 'Laporan Bencana Telah Dipublikasikan'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.bencana_published',
            with: [
                'name'          => $this->data['name'],
                'jenis_bencana' => $this->data['jenis_bencana'],
                'lokasi'        => $this->data['lokasi'],
                'tgl'           => $this->data['tgl'],
            ],
        );
    }
}
