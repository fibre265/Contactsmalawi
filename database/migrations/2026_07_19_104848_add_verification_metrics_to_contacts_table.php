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
        // Target the existing 'users' table
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('working_votes')->default(0);
            $table->unsignedInteger('not_working_votes')->default(0);
            // Status state: 'verified', 'pending_review', or 'flagged'
            $table->string('verification_status')->default('verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['working_votes', 'not_working_votes', 'verification_status']);
        });
    }
};