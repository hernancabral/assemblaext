<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanningTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planning_ticket', function (Blueprint $table) {
            $table->unsignedBigInteger('planning_id')->nullable();
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->primary(['planning_id','ticket_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planning_ticket');
    }
}
