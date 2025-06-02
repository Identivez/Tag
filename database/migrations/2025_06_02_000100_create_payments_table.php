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
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('PaymentId');
            $table->unsignedInteger('OrderId')->index('payments_orderid_foreign');
            $table->string('UserId', 450)->index('payments_userid_foreign');
            $table->string('PaymentMethod', 50)->nullable();
            $table->decimal('Amount', 10)->nullable();
            $table->string('PaymentStatus', 20)->nullable();
            $table->dateTime('TransactionDate')->nullable();
            $table->string('PaymentProvider', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
