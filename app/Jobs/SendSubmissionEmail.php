<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\EmailApiService; // Import service Anda

class SendSubmissionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emailData;

    /**
     * Data dilempar dari Controller ke sini
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Logika yang dijalankan oleh queue:work
     */
    public function handle()
    {
        EmailApiService::send(
            $this->emailData['to'],
            $this->emailData['subject'],
            $this->emailData['text'],
            $this->emailData['html']
        );
    }
}
