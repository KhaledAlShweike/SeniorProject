<?php

use App\Models\Cases;
use App\Models\Condition;
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
        Schema::connection('ehr')->create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->boolean('probability');
            $table->dateTime('last_updated');
            $table->boolean('is_secret');
            $table->foreignIdFor(Condition::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Cases::class)->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnoses');
    }
};
