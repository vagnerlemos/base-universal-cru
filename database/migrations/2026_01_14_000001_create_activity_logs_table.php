<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('app')->nullable(); // system, vendas, etc
            $table->string('action');          // login, logout, create, update, delete, access
            $table->string('resource')->nullable(); // users, roles, clients, etc
            $table->unsignedBigInteger('resource_id')->nullable();

            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('url')->nullable();
            $table->string('method')->nullable();

            $table->json('data')->nullable(); // before / after / payload

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
