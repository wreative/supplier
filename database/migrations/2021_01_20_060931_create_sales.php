<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->bigInteger('dsc');
            $table->bigInteger('dsc_nom');
            $table->bigInteger('dsc_per');
            $table->string('info')->nullable();
            $table->bigInteger('dp');
            $table->bigInteger('tax');
            $table->boolean('ppn');
            $table->bigInteger('etc_price')->nullable();
            $table->bigInteger('ship_price')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
