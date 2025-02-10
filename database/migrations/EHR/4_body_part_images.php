<?php

use App\Models\BodyPart;
use App\Models\Image;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::connection('ehr')->create('body_part_images', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BodyPart::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Image::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::connection('ehr')->dropIfExists('body_part_images');
    }
};
