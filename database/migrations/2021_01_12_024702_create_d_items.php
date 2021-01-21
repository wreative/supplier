<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('price');
            $table->bigInteger('profit')->nullable();
            $table->bigInteger('sell_price');
            $table->boolean('ppn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_items');
    }
}
