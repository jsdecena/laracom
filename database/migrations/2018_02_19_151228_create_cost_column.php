<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('couriers', function (Blueprint $table) {
            $table->decimal('cost')->nullable()->default('0.00')->after('is_free');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('couriers', function (Blueprint $table) {
            $table->dropColumn(['cost']);
        });
    }
}
