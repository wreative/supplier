<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->json('dsc');
            $table->string('info')->nullable();
            $table->bigInteger('dp');
            $table->bigInteger('tax');
            $table->boolean('ppn');
            $table->bigInteger('etc_price')->nullable();
            $table->bigInteger('ship_price')->nullable();
            $table->enum('status', ['Dipesan', 'Diterima']);
            $table->enum('pay', ['Tempo', 'Dibayar']);
            $table->bigInteger('payment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase');
    }
}
