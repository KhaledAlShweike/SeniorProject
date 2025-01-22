<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // This could be tenant1.myapp.test, or tenant1.myapp.com, etc.
            $table->string('domain')->unique();
            // Database name specifically for this tenant
            $table->string('database')->unique();
            // Optional: username/password if each DB uses unique creds
            $table->string('username')->nullable();
            $table->string('password')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tenants');
    }
};
