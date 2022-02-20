<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('deck');
            $table->string('name');
            $table->string('gender')->nullable()->default(null);
            $table->integer('votes')->default(0);
            $table->boolean('married')->default(false);
            $table->boolean('instant')->default(false);
            $table->boolean('disaster')->default(false);
            $table->boolean('on_board')->default(false);
            $table->boolean('is_next')->default(false);
            $table->foreignId('player_id')->nullable()->constrained()->default(null);
            $table->foreignId('village_id')->nullable()->constrained()->default(null);
            $table->foreignId('cross_id')->nullable()->default(null);
            $table->foreignId('crown_id')->nullable()->default(null);
            $table->foreignId('game_id')->constrained();
            $table->string('card_img');
            $table->string('verso_img');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
