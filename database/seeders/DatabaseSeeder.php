<?php

namespace Database\Seeders;

use App\Models\Leaderboard;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        \App\Models\User::factory(10)->create();

        // $leaderboard         = new Leaderboard();
        // $leaderboard->name   = 'Ashraf';
        // $leaderboard->points = '0';
        // $leaderboard->save();

        $user                    = new User();
        $user->name              = "Ashraf";
        $user->email             = "ashrafuddin765@gmail.com";
        $user->email_verified_at = now();
        $user->role              = 'admin';
        $user->password          = Hash::make( "hNT*v%$*86Ye" );
        $user->save();

        $user                    = new User();
        $user->name              = "Tanjim";
        $user->email             = "tanjim9816@gmail.com";
        $user->email_verified_at = now();
        $user->password          = Hash::make( 'M6ST23bZ$vWP' );
        $user->save();


        User::factory(10)->create();
        Leaderboard::factory(100)->create();
    }
}
