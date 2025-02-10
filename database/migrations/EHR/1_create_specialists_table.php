<?php

use App\Models\Degree;
use App\Models\Institution;
use App\Models\SpecialistType;
use App\Models\Specialization;
use App\Models\User;
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
        Schema::connection('ehr')->create('specialists', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('degree');
            $table->integer('specialization');
            $table->text('bio')->nullable();
            $table->boolean('certified');
            $table->foreignIdFor(Institution::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(SpecialistType::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Degree::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Specialization::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialists');
    }
};
