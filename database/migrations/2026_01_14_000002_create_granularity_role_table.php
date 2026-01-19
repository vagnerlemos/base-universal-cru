<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('granularity_role', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('granularity_id');
            $table->unsignedBigInteger('role_id');

            $table->timestamps();

            $table->unique(['granularity_id', 'role_id']);

            $table->foreign('granularity_id')->references('id')->on('granularities')->cascadeOnDelete();
            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('granularity_role');
    }
};
