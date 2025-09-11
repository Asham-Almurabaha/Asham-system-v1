<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // TODO: other schedules
        if (class_exists(\Illuminate\Support\Facades\Artisan::class)) {
            $schedule->command('hr:check-document-expiry')
                ->dailyAt('09:00')
                ->timezone('Asia/Riyadh');
        }
    }
}
