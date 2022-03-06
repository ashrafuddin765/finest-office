<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Foundation\Bus\Dispatchable;

class PendingPointReminder {
    use Dispatchable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        //

        User::where( 'role', 'admin' )->get()->each( function ( $user ) {
            $userData = [
                'body'     => 'You have pending points to be approved. Please login to your account to approve points.',
                'btn_text' => 'Approve now',
                'url'      => url( '/dashboard/pending-request' ),
                'thankyou' => '',
            ];
            $user->notify( new \App\Notifications\PendingPointNotify( $userData ) );
        } );
    }
}
