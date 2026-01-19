<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('granularities', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('app_id');

            $table->string('resource'); // ex: users
            $table->string('code');     // ex: users.field.cpf.hide
            $table->string('name');     // ex: Ocultar CPF
            $table->string('description')->nullable();

            $table->timestamps();

            $table->unique(['app_id', 'code']);

            $table->foreign('app_id')->references('id')->on('apps')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('granularities');
    }
};
