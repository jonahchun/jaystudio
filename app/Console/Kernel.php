<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $interval = config('common.sendNotificationEmailsCron');
        if ($interval === '*') {
            $schedule->command('customer:send_notification_emails')->everyMinute();
        } else {
            $schedule->command('customer:send_notification_emails')->cron($interval);
        }

        $interval = config('common.cleanPhotosCron');
        if ($interval === '*') {
            $schedule->command('customer:cleanUpTeaserPhotos')->everyMinute();
        } else {
            $schedule->command('customer:cleanUpTeaserPhotos')->cron($interval);
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
