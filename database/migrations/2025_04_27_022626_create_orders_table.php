<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_session_id');
            $table->string('payment_status')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('payment_session_id')
                  ->references('id')
                  ->on('payment_sessions')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
