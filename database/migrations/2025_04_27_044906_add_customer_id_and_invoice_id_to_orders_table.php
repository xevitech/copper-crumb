<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerIdAndInvoiceIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Adding the customer_id and invoice_id columns
            $table->unsignedBigInteger('customer_id')->nullable()->after('payment_status');
            $table->unsignedBigInteger('invoice_id')->nullable()->after('customer_id');
            
            // Adding foreign key constraints
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Dropping the foreign key constraints
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['invoice_id']);
            
            // Dropping the customer_id and invoice_id columns
            $table->dropColumn(['customer_id', 'invoice_id']);
        });
    }
}
