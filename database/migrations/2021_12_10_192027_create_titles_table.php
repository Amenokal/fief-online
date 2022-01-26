<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titles', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->integer('zone')->nullable()->default(null);
            $table->string('title_m')->nullable()->default(null);
            $table->string('title_f')->nullable()->default(null);
            $table->foreignId('lord_id')->nullable()->constrained()->default(null);
            $table->foreignId('player_id')->nullable()->constrained()->default(null);
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
        Schema::dropIfExists('titles');
    }
}
