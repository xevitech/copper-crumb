<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtpExpiresAtToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedSmallInteger('otp')->nullable()->after('avatar');
            $table->timestamp('otp_verified_at')->nullable()->after('otp');
            $table->timestamp('otp_expires_at')->nullable()->after('otp_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['otp', 'otp_verified_at','otp_expires_at']);
        });
    }
}
