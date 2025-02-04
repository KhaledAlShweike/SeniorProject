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
        Schema::connection('ehr')->create('case_symptoms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->references('id')->on('cases');
            $table->foreignId('symptom_id')->references('id')->on('symptoms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_symptoms');
    }
};
