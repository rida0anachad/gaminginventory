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
        $table->string('reference_number', 100)->nullable();
        $table->date('arrival_date');
        $table->decimal('total_cost', 10, 2)->default(0);
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
