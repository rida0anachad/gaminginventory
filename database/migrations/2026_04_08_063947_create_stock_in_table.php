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
    Schema::create('stock_in', function (Blueprint $table) {
        $table->id();
        $table->string('transaction_id')->unique();
        $table->foreignId('publisher_id')->constrained()->onDelete('cascade');
        $table->string('reference_number')->nullable();
        $table->date('arrival_date');
        $table->decimal('total_cost', 10, 2);
        $table->enum('payment_status', ['paid', 'pending', 'cancelled'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_in');
    }
};
