<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('family_name')->nullable();
            $table->string('color')->nullable();
            $table->integer('gold');
            $table->integer('married_to')->nullable();
            $table->integer('turn_order')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('game_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
