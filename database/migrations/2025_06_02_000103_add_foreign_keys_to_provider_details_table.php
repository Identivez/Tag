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
        Schema::table('provider_details', function (Blueprint $table) {
            $table->foreign(['ProductId'])->references(['ProductId'])->on('products')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['ProviderId'])->references(['ProviderId'])->on('providers')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('provider_details', function (Blueprint $table) {
            $table->dropForeign('provider_details_productid_foreign');
            $table->dropForeign('provider_details_providerid_foreign');
        });
    }
};
