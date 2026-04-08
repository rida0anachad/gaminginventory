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
    Schema::table('stock_ins', function (Blueprint $table) {
        $table->foreignId('game_id')
              ->nullable()
              ->after('publisher_id')
              ->constrained()
              ->onDelete('set null');
        $table->integer('quantity_received')->default(0)->after('game_id');
    });
}
/**
     * Reverse the migrations.
     */

public function down(): void
{
    Schema::table('stock_ins', function (Blueprint $table) {
        $table->dropForeign(['game_id']);
        $table->dropColumn(['game_id', 'quantity_received']);
    });
}

};
