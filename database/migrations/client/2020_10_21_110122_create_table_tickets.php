<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status_id');
            $table->integer('client_id');
            $table->integer('user_id');
            $table->integer('call_id');
            $table->integer('tickets_type_id');
            $table->integer('company_id');
            $table->integer('priority_id');
            $table->string('tittle');
            $table->longText('note');
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
