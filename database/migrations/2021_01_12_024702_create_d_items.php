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
            $table->bigInteger('price_inc');
            $table->bigInteger('price_exc')->nullable();
            $table->bigInteger('profit')->nullable();
            $table->bigInteger('price');
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
