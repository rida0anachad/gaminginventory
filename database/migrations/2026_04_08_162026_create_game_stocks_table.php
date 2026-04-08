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
        Schema::create('game_stocks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('game_id')
              ->constrained()
              ->onDelete('cascade');
        $table->string('sku', 100)->nullable()->unique();
        $table->date('release_date')->nullable();
        $table->integer('qty')->default(0);
        $table->decimal('mrp', 8, 2)->default(0);
        $table->decimal('rate', 8, 2)->default(0);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_stocks');
    }
};
