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
        Schema::create('queries', function (Blueprint $table) {
            $table->id('QueryID');
            $table->foreignId('TenantID')->constrained('institutions')->onDelete('cascade');
            $table->foreignId('UserID')->constrained('users')->onDelete('cascade');
            $table->enum('InputType', ['Text', 'Image', 'Voice']);
            $table->text('QueryInput');
            $table->text('QueryOutput');
            $table->timestamp('Timestamp')->useCurrent();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queries');
    }
};
