<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTicketsStatusChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('tickets_status_changes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tasks_id');
            $table->integer('prev_status');
            $table->integer('now_status');
            $table->integer('user_id');
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
        Schema::connection('client')->dropIfExists('tickets_status_changes');
    }
}
