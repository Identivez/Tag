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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('ProductId');
            $table->string('Name', 100);
            $table->string('Brand', 100)->nullable();
            $table->decimal('Price', 10);
            $table->text('Description')->nullable();
            $table->dateTime('CreatedAt')->nullable();
            $table->integer('Quantity')->nullable();
            $table->dateTime('LastUpdate')->nullable();
            $table->integer('Stock')->nullable();
            $table->unsignedInteger('ProviderId')->nullable()->index('ix_product_providerid');
            $table->unsignedInteger('CategoryId')->nullable()->index('ix_product_categoryid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
