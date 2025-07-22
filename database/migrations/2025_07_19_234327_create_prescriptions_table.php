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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('consultation_id'); // Reference to the consultation related to this prescription
            $table->text('notes')->nullable(); // e.g., additional notes from the doctor regarding the prescription
            $table->timestamp('prescription_date'); // e.g., date when the prescription was created
            $table->boolean('is_active')->default(true); // e.g., whether the prescription is active or archived
            $table->boolean('is_suspended')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
