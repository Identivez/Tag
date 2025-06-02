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
        Schema::create('role_user', function (Blueprint $table) {
            $table->string('RoleId', 191)->index('role_user_roleid_foreign');
            $table->string('UserId', 191);
            $table->timestamps();
            $table->string('model_type')->default('AppModelsUser');

            $table->primary(['UserId', 'RoleId']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
