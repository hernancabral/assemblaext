<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrioritizedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prioritized', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order')->unsigned()->default(0);
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->unsignedBigInteger('people_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
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
        Schema::dropIfExists('prioritized');
    }
}
