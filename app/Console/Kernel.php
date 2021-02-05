<?php

namespace App\Console;

use App\Events\PlaylistsUpdateFailure;
use App\Events\PlaylistsUpdateSuccess;
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
        $schedule
            ->exec('cd /var/playlistdetective-scrapper && ./bin/updateAlgolia')
            ->appendOutputTo('./playlistdetective-scrapper.log')
            ->onFailure(function () {
                PlaylistsUpdateFailure::dispatch();
            })
            ->onSuccess(function () {
                PlaylistsUpdateSuccess::dispatch();
            })
            ->everyMinute()
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
