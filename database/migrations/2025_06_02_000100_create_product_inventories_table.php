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
        Schema::create('product_inventories', function (Blueprint $table) {
            $table->increments('InventoryId');
            $table->unsignedInteger('ProductId');
            $table->unsignedInteger('SizeId')->index('product_inventories_sizeid_foreign');
            $table->integer('Quantity')->default(0);
            $table->decimal('Price', 10)->nullable();
            $table->string('SKU', 50)->nullable();
            $table->string('Condition', 20)->default('New');
            $table->boolean('InStock')->default(true);
            $table->integer('ReorderLevel')->default(5);
            $table->timestamp('LastUpdated')->useCurrent();

            $table->unique(['ProductId', 'SizeId'], 'uq_productsize');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_inventories');
    }
};
