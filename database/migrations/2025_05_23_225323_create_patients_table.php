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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('address', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 50)->nullable();
            $table->char('zip_code', 5)->nullable();
            $table->string('phone', 20);
            $table->enum('sex', ['Masculino', 'Femenino', 'Sin especificar']);
            $table->date('birthdate')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
