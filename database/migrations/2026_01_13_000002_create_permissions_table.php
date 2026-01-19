<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('app_id')->constrained('apps')->cascadeOnDelete();

            // UI/organização
            $table->string('resource', 100);    // users, clients, etc.
            $table->string('code', 150);        // users.view, users.create...
            $table->string('name', 180);        // label amigável
            $table->string('description', 255)->nullable();

            $table->timestamps();

            $table->unique(['app_id', 'code']);
            $table->index(['app_id', 'resource']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
