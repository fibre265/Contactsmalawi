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
    Schema::create('donations', function (Blueprint $table) {
        $table->id();
        $table->string('donor_name')->nullable();
        $table->string('email')->nullable();
        $table->decimal('amount', 10, 2);
        $table->string('tx_ref')->unique(); // Unique transaction reference string
        $table->string('status')->default('pending'); // pending, completed, failed
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('donations');
}
};
