<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alias');
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('zip')->nullable();
            $table->string('state_code')->nullable();
            $table->string('city')->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('country_id')->unsigned()->index();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->integer('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->integer('status')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('addresses');
    }
}
