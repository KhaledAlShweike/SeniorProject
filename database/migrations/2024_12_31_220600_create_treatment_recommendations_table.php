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
        Schema::create('treatment_recommendations', function (Blueprint $table) {
            $table->id('RecommendationID');
            $table->foreignId('TenantID')->constrained('institutions')->onDelete('cascade');
            $table->foreignId('QueryID')->constrained('queries')->onDelete('cascade');
            $table->text('SuggestedDiagnosis');
            $table->text('SuggestedTreatment');
            $table->float('ConfidenceScore');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_recommendations');
    }
};
