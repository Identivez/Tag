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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('OrderId');
            $table->string('UserId', 450)->index('orders_userid_foreign');
            $table->dateTime('OrderDate')->nullable();
            $table->decimal('TotalAmount', 10)->nullable();
            $table->string('OrderStatus', 20)->nullable();
            $table->unsignedInteger('PaymentId')->nullable()->index('orders_paymentid_foreign');
            $table->string('ShippingMethod', 50)->nullable();
            $table->decimal('ShippingCost', 10)->nullable();
            $table->unsignedInteger('ShippingAddressId')->nullable()->index('orders_shippingaddressid_foreign');
            $table->unsignedInteger('BillingAddressId')->nullable()->index('orders_billingaddressid_foreign');
            $table->dateTime('CreatedAt')->nullable();
            $table->dateTime('UpdatedAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
