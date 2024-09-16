<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        \App\Console\Commands\ScheduleArticle::class,
        \App\Console\Commands\RevokeTokenExpires::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:schedule-article')->everyMinute();
        $schedule->command('app:revoke-token-expires')->everyFiveMinutes()->sendOutputTo('storage/logs/schedule.log');
        $schedule->command('app:revoke-user-pending-expires')->everyFiveSeconds()->sendOutputTo('storage/logs/schedule.log');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
