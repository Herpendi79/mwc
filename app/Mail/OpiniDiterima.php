<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OpiniDiterima extends Mailable
{
    use Queueable, SerializesModels;

    public $judul;
    public $penulis;

    public function __construct($judul, $penulis)
    {
        $this->judul = $judul;
        $this->penulis = $penulis;
    }

    public function build()
    {
        return $this->subject('Pemberitahuan: Opini Anda Telah Diterima')
            ->view('emails.opini_diterima');
    }
}
