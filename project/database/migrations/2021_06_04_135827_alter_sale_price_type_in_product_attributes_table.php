<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSalePriceTypeInProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::raw('ALTER TABLE product_attributes MODIFY sale_price NUMERIC(8, 2) DEFAULT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->string('sale_price')->nullable()->change();
        });
    }
}
