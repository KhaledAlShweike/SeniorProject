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
        Schema::create('cases', function (Blueprint $table) {
            $table->id('CaseID');
            $table->foreignId('TenantID')->constrained('institutions')->onDelete('cascade');
            $table->foreignId('PatientID')->constrained('patient_records')->onDelete('cascade');
            $table->foreignId('DiseaseID')->constrained('diseases')->onDelete('cascade');
            $table->foreignId('SymptomID')->constrained('symptoms')->onDelete('cascade');
            $table->text('CaseDescription');
            $table->enum('Status', ['Open', 'Resolved']);
            $table->timestamp('CreatedAt')->useCurrent();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
