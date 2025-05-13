<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOtpColumnInCustomersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('otp', 6)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedSmallInteger('otp')->nullable()->change();
        });
    }
}
