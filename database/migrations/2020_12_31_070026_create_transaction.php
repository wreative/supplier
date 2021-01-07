<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('items_id');
            $table->bigInteger('total');
            $table->string('code');
            $table->dateTime('tgl');
            $table->foreignId('unit_id');
            $table->string('info')->nullable();
            $table->foreignId('p_id')->nullable();
            $table->foreignId('s_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
