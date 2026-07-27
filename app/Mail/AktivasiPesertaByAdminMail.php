<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AktivasiPesertaByAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;

    public function __construct($userName)
    {
        $this->userName = $userName;

        Log::info('Nama yang dikirim ke email: ' . $userName);
    }
    public function build()
    {
        return $this->subject('Akun Anda Telah Dibuat Oleh Admin - MWC NU TUGU')
            ->view('emails.aktivasi_peserta_by_admin')
            ->with([
                'userName' => $this->userName,
            ]);
    }
}
