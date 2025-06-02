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
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('ReviewId');
            $table->unsignedInteger('ProductId')->index('reviews_productid_foreign');
            $table->string('UserId', 450)->index('reviews_userid_foreign');
            $table->integer('Rating')->nullable();
            $table->text('Comment')->nullable();
            $table->dateTime('ReviewDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
