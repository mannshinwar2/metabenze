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
          //$schedule->call('App\Http\Controllers\CpsIncomeController@cpsGeneration')->daily()->at('10:00')->timezone('Asia/Kolkata');
//          $schedule->call(function () {
//     app(\App\Http\Controllers\CpsIncomeController::class)->cpsGeneration();
// })->everyMinute()->timezone('Asia/Kolkata');
 $schedule->call(function () {
    app(\App\Http\Controllers\LevelIncomeController::class)->levelDistribution();
})->everyMinute()->timezone('Asia/Kolkata');

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
