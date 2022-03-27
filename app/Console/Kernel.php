<?php

namespace App\Console;

use App\Console\Commands\AssignAdminToTicket;
use App\Models\Comment;
use App\Models\Settings;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\RadiusAuth::class,
        Commands\ConsoleApi::class,
        AssignAdminToTicket::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {   $backup_at='00:00';
        $fun="daily";

        $backup_at_settings=Settings::get('auto_daily_backup_time');
        $backup_freq_settings=Settings::get('get_backup_frequency');
        if(isset($backup_at_settings))
            $backup_at=$backup_at_settings;

        if(isset($backup_freq_settings))
            $fun=$backup_freq_settings;
        $schedule->command('backup:run --only-db')->everySixHours();
        $schedule->command('backup:clear')->daily()->at($backup_at);
        $schedule->command('online:count')->everyMinute()->withoutOverlapping();
   //     $schedule->command('disconnect:users')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('status:change')->daily()->withoutOverlapping();
        $schedule->command('clear:loginlogs')->daily()->withoutOverlapping();
   //     $schedule->command('clear:stale')->everyThirtyMinutes()->withoutOverlapping();

        //          ->hourly();
//        $schedule->call(function () {
//            //Some Code
//        })->everyFiveMinutes()
//            ->name('some_name')
//            ->withoutOverlapping();
        $schedule->command("assign:admin")->everyThreeMinutes()->withoutOverlapping();
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
