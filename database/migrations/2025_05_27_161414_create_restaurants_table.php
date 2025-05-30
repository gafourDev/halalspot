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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->string('address');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('halal_certification')->nullable();
            $table->string('cuisine_type');
            $table->string('price_range')->nullable();
            $table->string('phone')->nullable();
            $table->text('image')->nullable(); // Assuming you want to store image URLs or paths
            $table->boolean('is_active')->default(true); // To manage active/inactive status
            $table->boolean('is_featured')->default(false); // To mark featured restaurants
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
