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
            $table->id('PrescriptionID');
            $table->foreignId('TenantID')->constrained('institutions')->onDelete('cascade');
            $table->foreignId('RecordID')->constrained('patient_records')->onDelete('cascade');
            $table->string('MedicationName');
            $table->string('Dosage');
            $table->text('Instructions');
            $table->timestamp('IssuedAt')->useCurrent();
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
