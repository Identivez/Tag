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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->increments('CartId');
            $table->string('UserId', 450)->index('cart_items_userid_foreign');
            $table->unsignedInteger('ProductId')->index('cart_items_productid_foreign');
            $table->integer('Quantity')->default(1);
            $table->decimal('Price', 10);
            $table->decimal('Total', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
