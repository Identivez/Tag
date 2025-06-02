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
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreign(['CountryId'])->references(['CountryId'])->on('countries')->onUpdate('restrict')->onDelete('set null');
            $table->foreign(['MunicipalityId'])->references(['MunId'])->on('municipalities')->onUpdate('restrict')->onDelete('set null');
            $table->foreign(['UserId'])->references(['UserId'])->on('users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign('addresses_countryid_foreign');
            $table->dropForeign('addresses_municipalityid_foreign');
            $table->dropForeign('addresses_userid_foreign');
        });
    }
};
