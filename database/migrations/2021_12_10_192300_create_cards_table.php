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
            $table->string('name');
            $table->string('deck');
            $table->string('gender')->nullable()->default(null);
            $table->integer('move')->nullable();
            $table->boolean('instant')->default(false);
            $table->boolean('disaster')->default(false);
            $table->boolean('on_board')->default(false);
            $table->boolean('is_next')->default(false);
            $table->string('img_src');
            $table->foreignId('game_id')->constrained();
            $table->foreignId('player_id')->nullable()->constrained()->default(null);
            $table->foreignId('village_id')->nullable()->constrained()->default(null);
            $table->foreignId('cross_id')->nullable()->default(null);
            $table->foreignId('crown_id')->nullable()->default(null);
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
