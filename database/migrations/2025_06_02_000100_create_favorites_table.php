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
        Schema::create('favorites', function (Blueprint $table) {
            $table->increments('FavoriteId');
            $table->string('UserId', 450);
            $table->unsignedInteger('ProductId')->index('favorites_productid_foreign');
            $table->dateTime('AddedAt')->nullable();

            $table->unique(['UserId', 'ProductId'], 'uq_favorites_userproduct');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
