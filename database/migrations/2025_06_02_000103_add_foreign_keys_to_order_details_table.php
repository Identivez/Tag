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
        Schema::table('order_details', function (Blueprint $table) {
            $table->foreign(['OrderId'])->references(['OrderId'])->on('orders')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['ProductId'])->references(['ProductId'])->on('products')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropForeign('order_details_orderid_foreign');
            $table->dropForeign('order_details_productid_foreign');
        });
    }
};
