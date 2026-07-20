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
        Schema::table('users', function (Blueprint $table) {
            // Add not_working_votes if it's missing
            if (!Schema::hasColumn('users', 'not_working_votes')) {
                $table->unsignedInteger('not_working_votes')->default(0)->after('working_votes');
            }
            
            // Add verification_status if it's missing
            if (!Schema::hasColumn('users', 'verification_status')) {
                $table->string('verification_status')->default('verified')->after('not_working_votes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['not_working_votes', 'verification_status']);
        });
    }
};