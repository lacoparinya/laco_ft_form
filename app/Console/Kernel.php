<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Symfony\Component\Console\Command\Command;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\GenDailyReport::class,
        Commands\GenDailyPackReport::class,
        Commands\GenDailyFreezeReport::class,
        Commands\GenDailyPreReport::class,
        Commands\GenDailyFreeze2Report::class,
        Commands\GenDailyPre2Report::class,
        Commands\GenDailySelect2Report::class,
        Commands\GenDailyPack2Report::class,
        Commands\GenDailyStampReport::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
