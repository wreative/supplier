<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_customer', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->string('no_rek')->nullable();
            $table->string('name_rek')->nullable();
            $table->string('bank')->nullable();
            $table->string('npwp')->nullable();
            $table->string('info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_customer');
    }
}
