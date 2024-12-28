<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('User ID'); // Primary Key
            $table->foreignId('TenantID')->constrained('tenants', 'TenantID')->onDelete('cascade'); // Foreign Key
            $table->string('User Name'); // User Name
            $table->string('Email')->unique(); // Email
            $table->string('Password'); // Encrypted Password
            $table->enum('Role', ['Doctor', 'Patient', 'Admin']); // Role
            $table->timestamps(); // CreatedAt and UpdatedAt
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
