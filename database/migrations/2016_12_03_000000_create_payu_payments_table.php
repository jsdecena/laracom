<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayuPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payu_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account');
            $table->unsignedInteger('payable_id')->nullable();
            $table->string('payable_type')->nullable();
            $table->string('txnid');
            $table->string('mihpayid');
            $table->string('firstname');
            $table->string('lastname')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->double('amount');
            $table->double('discount')->default(0);
            $table->double('net_amount_debit')->default(0);
            $table->text('data');
            $table->string('status');
            $table->string('unmappedstatus');
            $table->string('mode')->nullable();
            $table->string('bank_ref_num')->nullable();
            $table->string('bankcode')->nullable();
            $table->string('cardnum')->nullable();
            $table->string('name_on_card')->nullable();
            $table->string('issuing_bank')->nullable();
            $table->string('card_type')->nullable();
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
        Schema::drop('payu_payments');
    }
}
