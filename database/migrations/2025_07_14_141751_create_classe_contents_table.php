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
        Schema::create('classe_contents', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->unique();
            $table->unsignedBigInteger('classe_id');
            $table->unsignedBigInteger('content_type_id');
            $table->json('content');
            $table->integer('order');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('classe_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('content_type_id')->references('id')->on('content_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classe_contents');
    }
};
