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

        Schema::create('restaurant_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id'); // Foreign key to restaurants table
            $table->string('image_path'); // Path or URL to the image
            $table->string('image_type')->nullable(); // Type of image, e.g., 'logo', 'interior', 'exterior'
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('restaurant_id')
                ->references('id')
                ->on('restaurants')
                ->onDelete('cascade'); // Delete images if the restaurant is deleted

            // Index for faster lookups
            $table->index('restaurant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_images');
    }
};
