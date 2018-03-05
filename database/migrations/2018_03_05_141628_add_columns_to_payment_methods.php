<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToPaymentMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->string('account_id')->nullable()->unique()->after('description');
            $table->string('client_id')->nullable()->unique()->after('account_id');
            $table->string('client_secret')->nullable()->unique()->after('client_id');
            $table->string('api_url')->nullable()->unique()->after('client_secret');
            $table->string('redirect_url')->nullable()->after('api_url');
            $table->string('cancel_url')->nullable()->after('redirect_url');
            $table->string('failed_url')->nullable()->after('cancel_url');
            $table->string('mode')->after('failed_url')->default('sandbox');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn([
                'account_id',
                'client_id',
                'client_secret',
                'api_url',
                'redirect_url',
                'cancel_url',
                'failed_url',
                'mode'
            ]);
        });
    }
}
