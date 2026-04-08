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
        Schema::create('members', function (Blueprint $table) {
        $table->id();
        $table->string('member_id', 20)->unique();
        $table->string('name', 100);
        $table->string('contact_number', 50)->nullable();
        $table->text('address')->nullable();
        $table->string('favorite_genre', 80)->nullable();
        $table->string('platform_preference', 80)->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
