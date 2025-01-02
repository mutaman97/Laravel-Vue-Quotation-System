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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('fullName'); // For the user's full name
            $table->string('username')->unique(); // For the username
            $table->string('password');
            $table->string('avatar')->nullable(); // For the avatar URL
            $table->string('email')->unique();
            $table->string('role'); // For the user role
            $table->json('abilityRules')->nullable(); // For ability rules
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
