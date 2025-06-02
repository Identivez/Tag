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
        Schema::table('product_inventories', function (Blueprint $table) {
            $table->foreign(['ProductId'])->references(['ProductId'])->on('products')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['SizeId'])->references(['SizeId'])->on('sizes')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_inventories', function (Blueprint $table) {
            $table->dropForeign('product_inventories_productid_foreign');
            $table->dropForeign('product_inventories_sizeid_foreign');
        });
    }
};
