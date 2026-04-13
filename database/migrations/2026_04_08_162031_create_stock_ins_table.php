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
        Schema::create('stock_ins', function (Blueprint $table) {
        $table->id();
        $table->string('transaction_id', 50)->unique();
        $table->foreignId('publisher_id')
              ->nullable()
              ->constrained()
              ->onDelete('set null');
        $table->foreignId('game_id')
              ->nullable()
              ->constrained()
              ->onDelete('set null');
        $table->integer('quantity_received')->default(0);
        $table->decimal('cost_price', 8, 2)->default(0);
        $table->decimal('sale_rate', 8, 2)->default(0);
        $table->string('reference_number', 100)->nullable();
        $table->date('arrival_date');
        $table->enum('payment_status', ['paid', 'pending', 'partial'])
              ->default('pending');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ins');
    }
};
