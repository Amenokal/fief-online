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
        Schema::create('lord_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->boolean('on_board')->default(false);
            $table->string('type')->default('lord');
            $table->integer('order')->nullable();
            $table->string('img_src');
            $table->foreignId('game_id')->constrained();
            $table->foreignId('player_id')->nullable()->constrained()->default(null);
            $table->foreignId('village_id')->nullable()->constrained()->default(null);
            $table->softDeletes();        
        });

        Schema::create('event_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('instant');
            $table->boolean('on_board')->default(false);
            $table->string('type');
            $table->integer('order')->nullable();
            $table->string('img_src');
            $table->foreignId('game_id')->constrained();
            $table->foreignId('player_id')->nullable()->constrained()->default(null);
            $table->foreignId('lord_title_id')->nullable()->constrained()->default(null);
            $table->foreignId('religious_title_id')->nullable()->constrained()->default(null);
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
        Schema::dropIfExists('lord_cards');
        Schema::dropIfExists('event_cards');
    }
}
