<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('team_name');
            $table->integer('player_1_id')->unique();
            $table->string('player_1');
            $table->integer('player_2_id')->unique();
            $table->string('player_2');
            $table->integer('played');
            $table->integer('win');
            $table->integer('lose');
            $table->integer('point');
            $table->double('net_point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
