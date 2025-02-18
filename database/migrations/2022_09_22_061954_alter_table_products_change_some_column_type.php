<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProductsChangeSomeColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->float('weight',13,3)->nullable()->change();
            $table->float('dimension_l',13,3)->nullable()->change();
            $table->float('dimension_w',13,3)->nullable()->change();
            $table->float('dimension_d',13,3)->nullable()->change();
            $table->float('custom_tax',13,3)->nullable()->change();
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
            //
        });
    }
}
