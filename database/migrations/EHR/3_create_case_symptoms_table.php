<?php

use App\Models\Cases;
use App\Models\Symptom;
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
            $table->boolean('present');
            $table->foreignIdFor(Cases::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Symptom::class)->constrained()->onDelete('cascade');
            $table->dateTime('last_updated');
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
