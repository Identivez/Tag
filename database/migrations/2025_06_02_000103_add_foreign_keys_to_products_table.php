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
        Schema::table('products', function (Blueprint $table) {
            $table->foreign(['CategoryId'])->references(['CategoryId'])->on('categories')->onUpdate('restrict')->onDelete('set null');
            $table->foreign(['ProviderId'])->references(['ProviderId'])->on('providers')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_categoryid_foreign');
            $table->dropForeign('products_providerid_foreign');
        });
    }
};
