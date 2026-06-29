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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Display name (e.g., "SEMINOLE")
            $table->string('slug')->unique(); // URL-friendly identifier (e.g., "seminole")
            $table->text('address'); // Full address
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->text('hours_of_operation')->nullable();
            $table->text('google_maps_address'); // For Google Maps embed
            $table->string('virtual_tour_image')->nullable(); // Image path for virtual tour
            $table->string('virtual_tour_label')->nullable(); // Label for virtual tour (e.g., "FRONT OFFICE")
            $table->string('home_page_image')->nullable(); // Image for home page location card
            $table->integer('display_order')->default(0); // Order for display
            $table->boolean('is_active')->default(true); // Show/hide location
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
