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
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('AddressId');
            $table->string('UserId', 450)->index('addresses_userid_foreign');
            $table->text('AddressLine1');
            $table->text('AddressLine2')->nullable();
            $table->text('City');
            $table->text('State');
            $table->integer('ZipCode')->nullable();
            $table->text('Country');
            $table->unsignedInteger('CountryId')->nullable()->index('addresses_countryid_foreign');
            $table->unsignedInteger('MunicipalityId')->nullable()->index('addresses_municipalityid_foreign');
            $table->string('AddressType', 50);
            $table->boolean('IsDefault')->default(false);
            $table->timestamp('CreatedAt')->useCurrent();
            $table->dateTime('UpdatedAt')->nullable();
            $table->boolean('IsActive')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
