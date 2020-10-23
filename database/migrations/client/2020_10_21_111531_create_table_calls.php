<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCalls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('client')->create('calls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_id');
            $table->string('client_id');
            $table->dateTime('date');
            $table->string('sender');
            $table->string('phone_number');
            $table->longText('motive');
            $table->longText('solution');
            $table->integer('duration');
            $table->boolean('status');
            $table->timestamps();
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calls');
    }
}
