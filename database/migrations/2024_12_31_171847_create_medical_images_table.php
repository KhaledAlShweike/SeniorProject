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
        Schema::create('medical_images', function (Blueprint $table) {
            $table->id('ImageID');
            $table->foreignId('RecordID')->constrained('patient_records')->onDelete('cascade');
            $table->text('ImageURL');
            $table->text('Metadata');
            $table->timestamp('CreatedAt')->useCurrent();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_images');
    }
};
