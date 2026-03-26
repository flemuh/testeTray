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

            // OAuth Google
            $table->string('google_id')->nullable()->unique();
            $table->text('google_access_token')->nullable();
            $table->text('google_refresh_token')->nullable();
            $table->timestamp('google_token_expires_at')->nullable();

            // Dados básicos
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();

            // Cadastro complementar
            $table->string('name')->nullable();
            $table->string('cpf', 11)->nullable()->unique();
            $table->date('birth_date')->nullable();

            $table->timestamps();

            $table->index('name');
            $table->index('cpf');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
