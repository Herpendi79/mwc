<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AktivasiPesertaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;

    public function __construct($userName)
    {
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->subject('Notifikasi Registrasi Akun MWC NU TUGU')
            ->view('emails.aktivasi_peserta')
            ->with([
                'userName' => $this->userName
            ]);
    }
}
