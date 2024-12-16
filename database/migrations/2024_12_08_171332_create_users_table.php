<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // User name (no username column)
            $table->string('email')->unique(); // User email, must be unique
            $table->string('password'); // User password
            $table->timestamp('email_verified_at')->nullable(); // For email verification
            $table->rememberToken(); // Token for "remember me" functionality
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
