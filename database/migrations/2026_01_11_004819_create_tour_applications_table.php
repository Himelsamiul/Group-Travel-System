<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_applications', function (Blueprint $table) {
            $table->id();

            // Normal IDs (no foreign key)
            $table->unsignedBigInteger('tourist_id');
            $table->unsignedBigInteger('tour_package_id');

            // Tour-specific information
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('emergency_contact');
            $table->integer('final_amount');
            $table->integer('due');

            // Optional fields
            $table->string('note_name')->nullable();
            $table->text('special_note')->nullable();

            // Status
            $table->enum('status', ['pending', 'accepted', 'rejected'])
                  ->default('pending');

            $table->string('payment_status');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_applications');
    }
};
