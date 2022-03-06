<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaderboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('details')->nullable();
            $table->integer('points');
            $table->string('updated_by')->nullable();
            $table->unsignedBigInteger('status')->default(0)->comment('0=pending, 1=approved, 2=rejected');
            $table->timestamps();


            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' );

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaderboards');
    }
}
