<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computersassignments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visitor_id');
            $table->integer('computer_id');
            $table->integer('openday_id');
            $table->integer('open');
            $table->integer('close');
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
        Schema::dropIfExists('computersassignments');
    }
}
