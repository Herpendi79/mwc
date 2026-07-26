<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $newPassword;
    public $email;

    /**
     * Create a new message instance.
     */
    public function __construct($nama, $newPassword, $email)
    {
        $this->nama = $nama;
        $this->newPassword = $newPassword;
        $this->email = $email;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Password Baru Anda - MWC NU TUGU')
            ->view('emails.reset-password');
    }
}
