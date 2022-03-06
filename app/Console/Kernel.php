<?php

namespace App\Console;

use App\Jobs\PendingPointReminder;
use App\Models\Leaderboard;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule( Schedule $schedule ) {
        $leaderboard = Leaderboard::where( 'status', '0' )->get();
        // $schedule->command('inspire')->hourly();
        // $schedule->job(LeaderbardPDFGenerator::dispatch())->everyMinute();

        if ( $leaderboard->count() > 0 ) {
            $schedule->job( PendingPointReminder::dispatch() )->dailyAt( '05:40' );
        }

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load( __DIR__ . '/Commands' );

        require base_path( 'routes/console.php' );
    }
}
