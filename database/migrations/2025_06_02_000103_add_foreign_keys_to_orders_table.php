<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign(['BillingAddressId'])->references(['AddressId'])->on('addresses')->onUpdate('restrict')->onDelete('set null');
            $table->foreign(['PaymentId'])->references(['PaymentId'])->on('payments')->onUpdate('restrict')->onDelete('set null');
            $table->foreign(['ShippingAddressId'])->references(['AddressId'])->on('addresses')->onUpdate('restrict')->onDelete('set null');
            $table->foreign(['UserId'])->references(['UserId'])->on('users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_billingaddressid_foreign');
            $table->dropForeign('orders_paymentid_foreign');
            $table->dropForeign('orders_shippingaddressid_foreign');
            $table->dropForeign('orders_userid_foreign');
        });
    }
};
