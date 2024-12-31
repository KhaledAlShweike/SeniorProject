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
        Schema::create('access_logs', function (Blueprint $table) {
            $table->id('LogID');
            $table->foreignId('TenantID')->constrained('institutions')->onDelete('cascade');
            $table->foreignId('UserID')->constrained('users')->onDelete('cascade');
            $table->string('Action', 255);
            $table->timestamp('Timestamp')->useCurrent();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_logs');
    }
};
