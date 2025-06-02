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
        Schema::create('users', function (Blueprint $table) {
            $table->string('UserId', 450)->primary();
            $table->text('firstName')->nullable();
            $table->text('lastName')->nullable();
            $table->dateTime('createdAt')->nullable();
            $table->timestamp('updatedAt')->nullable();
            $table->string('email', 256)->nullable();
            $table->string('password', 256)->nullable();
            $table->rememberToken();
            $table->text('phoneNumber')->nullable();
            $table->unsignedInteger('MunicipalityId')->nullable()->index('users_municipalityid_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
