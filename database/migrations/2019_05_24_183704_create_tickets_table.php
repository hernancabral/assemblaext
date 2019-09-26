<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('nro');
            $table->string('space_id');
            $table->string('title');
            $table->string('code');
            $table->unsignedBigInteger('milestone_id')->nullable();
            $table->unsignedBigInteger('assigned_id')->nullable();
            $table->unsignedBigInteger('tester_id')->nullable();
            $table->string('status')->nullable();
            $table->float('work_remaining')->nullable();
            $table->float('worked_hours')->nullable();
            $table->float('estimate')->nullable();
            $table->float('original_estimate')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->time('production_date')->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
