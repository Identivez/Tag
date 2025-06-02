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
        Schema::create('order_details', function (Blueprint $table) {
            $table->unsignedInteger('OrderId');
            $table->unsignedInteger('ProductId')->index('order_details_productid_foreign');
            $table->integer('Quantity');
            $table->decimal('UnitPrice', 10)->nullable();
            $table->unsignedInteger('CouponId')->nullable();

            $table->primary(['OrderId', 'ProductId']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
