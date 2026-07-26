<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DonasiBerhasilMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $noSertifikat;

    public function __construct($name, $noSertifikat)
    {
        $this->name = $name;
        $this->noSertifikat = $noSertifikat;
    }

    // Ubah Envelope untuk mendefinisikan subject
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Terima Kasih Atas Donasi Anda',
        );
    }

    // Ubah Content untuk menunjuk ke file view yang benar
    public function content(): Content
    {
        return new Content(
            // Pastikan path ini sesuai dengan lokasi file:
            // resources/views/emails/donasi_sukses.blade.php
            view: 'emails.donasi_sukses',
        );
    }
}
