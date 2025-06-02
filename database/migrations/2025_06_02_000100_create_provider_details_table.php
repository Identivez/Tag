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
        Schema::create('provider_details', function (Blueprint $table) {
            $table->increments('ProviderDetailsId');
            $table->unsignedInteger('ProviderId');
            $table->unsignedInteger('ProductId')->index('provider_details_productid_foreign');
            $table->decimal('Price', 10)->nullable();
            $table->integer('Quantity')->nullable();
            $table->date('SupplyDate')->nullable();

            $table->unique(['ProviderId', 'ProductId'], 'uq_providerdetails');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_details');
    }
};
