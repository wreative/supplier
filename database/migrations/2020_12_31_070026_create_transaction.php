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
            $table->foreignId('p_id')->nullable();
            $table->foreignId('s_id')->nullable();
            $table->foreignId('sup_id')->nullable();
            $table->foreignId('cus_id')->nullable();
            $table->foreignId('mar_id')->nullable();
            $table->date('tgl');
            $table->bigInteger('price');
            $table->bigInteger('c_price')->nullable()->default(0);
            $table->bigInteger('total');
            $table->foreignId('pay_id');
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
