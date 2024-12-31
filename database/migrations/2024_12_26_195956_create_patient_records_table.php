<?php

use App\Models\Media;
use App\Models\Patient;
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
        Schema::create('patient_records', function (Blueprint $table) {
            $table->id('RecordID');
            $table->foreignId('InstitutionID')->constrained('institutions')->onDelete('cascade');
            $table->foreignId('UserID')->constrained('users')->onDelete('cascade');
            $table->string('PatientName');
            $table->text('PatientDetails');
            $table->text('MedicalHistory');
            $table->timestamp('CreatedAt')->useCurrent();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_cases');
    }
};
