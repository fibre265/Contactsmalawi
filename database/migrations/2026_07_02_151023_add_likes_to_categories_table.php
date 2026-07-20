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
        Schema::table('categories', function (Blueprint $table) {
            // Adds an unsigned integer column defaulting to 0 likes
            $table->unsignedInteger('likes')->default(0)->after('category'); 
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('likes');
        });
    }
};
