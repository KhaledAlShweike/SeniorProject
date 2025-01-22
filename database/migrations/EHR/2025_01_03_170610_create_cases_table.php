<?php

use App\Models\Patient;
use App\Models\Specialist;
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
        Schema::connection('ehr')->create('cases', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Specialist::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Patient::class)->constrained()->onDelete('cascade');
            $table->boolean('isPrivate')->default(0);
            $table->dateTime('date');
            $table->text('notes')->nullable();
            $table->text('treatment_plan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropForeign(['specialist_id']);
            $table->dropForeign(['patient_id']);
            $table->dropColumn('treatment_plan');
        });
    }
};
