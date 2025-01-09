<?php

use App\Models\Patient;
use App\Models\Specialist;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Patient::class)->constrained('patients')->onDelete('cascade');
            $table->foreignIdFor(Specialist::class)->constrained('specialists')->onDelete('cascade');
            $table->text('diagnosis');
            $table->text('treatment_plan')->nullable();
            $table->enum('status', ['stored', 'archived'])->default('stored');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medical_records');
    }
}
