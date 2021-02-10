<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidding extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidding', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('cus_id');
            $table->json('items');
            $table->date('date');
            $table->boolean('ppn');
            $table->json('dsc');
            $table->bigInteger('gt'); // Grand Total
            $table->string('info')->nullable();
            $table->json('cost'); //Harga Total dan harga lain-lain
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bidding');
    }
}
