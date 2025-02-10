<?php

use App\Models\BodyPart;
use App\Models\Cases;
use App\Models\Type;
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
            $table->dateTime('date');
            $table->text('url');
            $table->boolean('uploaded_by_patient');
            $table->foreignIdFor(Cases::class)->constrained()->onDelete('cascade');
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
