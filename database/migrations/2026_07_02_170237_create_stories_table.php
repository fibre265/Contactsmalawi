<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('stories', function (Blueprint $table) {
        $table->id();
        $table->text('story'); // The success story text
        $table->string('location')->nullable(); // e.g., "Lilongwe" or "Blantyre" (Optional)
        $table->boolean('approved')->default(0); // Admin must approve it before it goes live
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('stories');
}
};
