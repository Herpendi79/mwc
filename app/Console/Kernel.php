<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected $commands = [
    
    ];


    protected function schedule(Schedule $schedule)
    {
        Log::info('Schedule ran at: ' . now()); // ← Tambahkan baris ini

        $schedule->command('queue:work --queue=conference --stop-when-empty --tries=3')
            ->everyMinute()
            ->withoutOverlapping();
    }



    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
