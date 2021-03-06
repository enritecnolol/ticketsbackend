<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCalendarEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('calendar_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->date('start');
            $table->date('end_date');
            $table->string('classname');
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
        Schema::connection('client')->dropIfExists('calendar_events');
        Schema::connection('client')->dropIfExists('calendar_events');
        Schema::connection('client')->dropIfExists('calendar_events');
    }
}
