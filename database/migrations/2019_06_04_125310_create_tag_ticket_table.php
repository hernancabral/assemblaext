<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_ticket', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id')->nullable();
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->primary(['tag_id','ticket_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_ticket');
    }
}
