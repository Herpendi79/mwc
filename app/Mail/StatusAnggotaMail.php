<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusAnggotaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $action;
    public $userName; // Tambahkan properti untuk nama

    public function __construct($action, $userName)
    {
        $this->action = $action;
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->subject('Notifikasi Status Keanggotaan')
            ->view('emails.status_anggota')
            ->with([
                'action' => $this->action,
                'userName' => $this->userName
            ]);
    }
}
