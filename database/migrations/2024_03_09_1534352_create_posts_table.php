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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('businessName');
            $table->unsignedInteger('reviews')->default(0);
            $table->string('description');
            $table->json('images')->Notnullable(); // Change 'image' to 'images' and make it nullable
            $table->bigInteger('contactNumber')->unique();
            $table->boolean('is_active')->default(0);
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->string('type');
            $table->unsignedBigInteger('user_id')->nullable(); // Make user_id nullable
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
