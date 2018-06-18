<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsOnOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product', function (Blueprint $table) {
             $table->string('product_name')->nullable();
             $table->string('product_sku')->nullable();
             $table->text('product_description')->nullable();
             $table->decimal('product_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->dropColumn([
                'product_name',
                'product_sku',
                'product_description',
                'product_price'
            ]);
        });
    }
}
