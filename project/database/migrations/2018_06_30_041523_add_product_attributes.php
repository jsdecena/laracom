<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('length')->nullable()->after('status');
            $table->decimal('width')->nullable()->after('length');
            $table->decimal('height')->nullable()->after('width');
            $table->string('distance_unit')->nullable()->after('height');
            $table->decimal('weight')->default(0)->nullable()->after('distance_unit');
            $table->string('mass_unit')->nullable()->after('weight');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['length', 'width', 'height', 'distance_unit', 'weight', 'mass_unit']);
        });
    }
}
