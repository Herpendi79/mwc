<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SampahTerkirimMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Konfirmasi Penyetoran Sampah');
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.sampah_sukses',
            with: [
                'name' => $this->data['penyetor'],
                'jenis' => $this->data['jenis'],
                'berat' => $this->data['berat'],
                'nilai' => $this->data['nilai'],
            ],
        );
    }
}
