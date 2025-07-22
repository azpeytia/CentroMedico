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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('patient_id');
            $table->timestamp('consultation_date');
            $table->string('reason_for_consultation'); // e.g., symptoms or issues reported by the patient
            $table->string('allergies')->nullable(); // e.g., allergies to medications, foods, etc.
            $table->string('blood_pressure', 7)->nullable(); // e.g., 120/80 mmHg
            $table->string('heart_rate', 3)->nullable(); // e.g., in bpm
            $table->string('respiratory_rate', 3)->nullable(); // e.g., in breaths per minute
            $table->string('oxygen_saturation', 3)->nullable(); // e.g., in percentage
            $table->string('temperature', 3)->nullable(); // e.g., in Celsius or Fahrenheit
            $table->string('weight', 3)->nullable(); // e.g., in kg or lbs
            $table->string('height', 3)->nullable(); // e.g., in cm or ft/in
            $table->string('medications')->nullable(); // e.g., current medications the patient is taking
            $table->string('medical_conditions')->nullable(); // e.g., diabetes, hypertension
            $table->string('medical_history')->nullable(); // e.g., previous illnesses or surgeries
            $table->string('family_history')->nullable(); // e.g., family medical conditions
            $table->string('diagnosis')->nullable(); // e.g., doctor's diagnosis based on the consultation
            $table->string('treatment')->nullable(); // e.g., plan for managing the patient's condition
            $table->string('follow_up_instructions')->nullable(); // e.g., instructions for follow-up care
            $table->text('notes')->nullable(); // e.g., additional notes from the doctor
            $table->boolean('is_active')->default(true); // e.g., whether the consultation is active or archived
            $table->boolean('is_suspended')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};