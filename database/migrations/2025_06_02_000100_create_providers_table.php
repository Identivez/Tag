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
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('ProviderId');
            $table->string('Name')->nullable();
            $table->string('ContactEmail', 256)->nullable();
            $table->string('ContactPhone', 20)->nullable();
            $table->text('Address')->nullable();
            $table->string('ContactName', 256)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
