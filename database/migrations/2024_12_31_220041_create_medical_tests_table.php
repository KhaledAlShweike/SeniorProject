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
        Schema::create('medical_tests', function (Blueprint $table) {
            $table->id('TestID');
            $table->foreignId('TenantID')->constrained('institutions')->onDelete('cascade');
            $table->foreignId('RecordID')->constrained('patient_records')->onDelete('cascade');
            $table->string('TestName');
            $table->text('TestResults');
            $table->timestamp('PerformedAt')->useCurrent();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_tests');
    }
};
