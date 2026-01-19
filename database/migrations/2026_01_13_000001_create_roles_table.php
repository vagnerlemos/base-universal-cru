<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('app_id')->constrained('apps')->cascadeOnDelete();
            $table->string('code', 100);   // técnico (admin, manager...)
            $table->string('name', 150);   // amigável

            $table->timestamps();

            $table->unique(['app_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
