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
    Schema::create('artists', function (Blueprint $table) {
        $table->id();
        $table->string('spotify_id');
        $table->string('name');
        $table->integer('popularity');
        $table->string('href');
        $table->string('uri');
        $table->unsignedBigInteger('followers');
        $table->string('external_url');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
