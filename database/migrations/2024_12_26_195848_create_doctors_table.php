<?php

use App\Models\Tenant;
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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id('DoctorID');
            $table->string('DoctorName');
            $table->string('email')->unique();
            $table->text('password');
            $table->string('phone_number');
            $table->string('photo');
            $table->string('role');
            $table->string('specialization');
            $table->string('clinic_address');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
