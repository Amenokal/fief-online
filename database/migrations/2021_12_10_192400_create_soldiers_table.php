<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoldiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soldiers', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('name')->nullable()->default(null);
            $table->string('gender')->nullable()->default(null);
            $table->integer('price')->default(0);
            $table->integer('power');
            $table->integer('pv')->default(0);
            $table->integer('move')->default(2);
            $table->boolean('just_arrived')->default(false);
            $table->foreignId('village_id')->nullable()->constrained()->default(null);
            $table->foreignId('player_id')->nullable()->constrained()->default(null);
            $table->foreignId('game_id')->constrained();
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
        Schema::dropIfExists('soldiers');
    }
}
