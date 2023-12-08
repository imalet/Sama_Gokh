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
<<<<<<<< HEAD:database/migrations/2023_12_07_101047_communes_tables.php
        Schema::create('communes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->unsignedBigInteger('ville_id');
            $table->foreign('ville_id')->references('id')->on('villes');
            $table->integer('nombre_citoyen');
            $table->string('image');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
========
        Schema::create('villes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
>>>>>>>> feature/samagokhjeanne:database/migrations/2020_12_08_095322_create_villes_table.php
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<<< HEAD:database/migrations/2023_12_07_101047_communes_tables.php
        Schema::dropIfExists('communes');
========
        Schema::dropIfExists('villes');
>>>>>>>> feature/samagokhjeanne:database/migrations/2020_12_08_095322_create_villes_table.php
    }
};
