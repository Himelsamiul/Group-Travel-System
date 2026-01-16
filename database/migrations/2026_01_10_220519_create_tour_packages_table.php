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
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('package_title');
            $table->string('short_description', 500);
            $table->longText('full_description');

            // Location
            $table->foreignId('place_id')
                  ->constrained('places')
                  ->cascadeOnDelete();

            // Schedule
            $table->date('start_date');
            $table->date('end_date');

            // Capacity
            $table->integer('max_persons');
            $table->integer('min_persons')->nullable();
            $table->integer('available_seats');
            $table->integer('booked')->default(0)->change();

            // Pricing
            $table->decimal('price_per_person', 10, 2);
            $table->decimal('discount', 5, 2)->nullable();

            // Relations
            $table->foreignId('hotel_id')
                  ->constrained('hotels')
                  ->cascadeOnDelete();

            $table->foreignId('transportation_id')
                  ->constrained('transportations')
                  ->cascadeOnDelete();

            // Included / Excluded
            $table->longText('included_items');
            $table->longText('excluded_items')->nullable();

            // Image
            $table->string('thumbnail_image');

            // Control
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_packages');
    }
};
