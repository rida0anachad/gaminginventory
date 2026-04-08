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
        Schema::create('games', function (Blueprint $table) {
        $table->id();
        $table->string('title', 200);
        $table->string('platform', 80)->nullable();
        $table->string('genre', 80)->nullable();
        $table->foreignId('publisher_id')
              ->nullable()
              ->constrained()
              ->onDelete('set null');
        $table->string('poster', 255)->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
