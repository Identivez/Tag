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
        Schema::table('favorites', function (Blueprint $table) {
            $table->foreign(['ProductId'])->references(['ProductId'])->on('products')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['UserId'])->references(['UserId'])->on('users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropForeign('favorites_productid_foreign');
            $table->dropForeign('favorites_userid_foreign');
        });
    }
};
