<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameSetUpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('mod')->nullable();
            $table->boolean('is_over')->default(false);
            $table->timestamps();
        });
        Schema::create('game_turns', function (Blueprint $table) {
            $table->id();
            $table->integer('player')->default(1);
            $table->integer('phase')->default(1);
            $table->integer('turn')->default(1);
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
        Schema::dropIfExists('games');
        Schema::dropIfExists('game_turns');
    }
}
