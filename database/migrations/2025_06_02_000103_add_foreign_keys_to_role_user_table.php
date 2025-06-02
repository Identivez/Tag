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
        Schema::table('role_user', function (Blueprint $table) {
            $table->foreign(['RoleId'])->references(['RoleId'])->on('roles')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['UserId'])->references(['UserId'])->on('users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->dropForeign('role_user_roleid_foreign');
            $table->dropForeign('role_user_userid_foreign');
        });
    }
};
