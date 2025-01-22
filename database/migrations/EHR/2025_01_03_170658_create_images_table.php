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
        Schema::connection('ehr')->create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->boolean('is_private');
            $table->integer('body_part')->nullable();
            $table->boolean('uploaded_by_patient');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
