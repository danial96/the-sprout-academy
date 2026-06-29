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
        Schema::create('enrollment_phones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->onDelete('cascade');
            $table->foreignId('enrollment_contact_id')->nullable()->constrained('enrollment_contacts')->onDelete('cascade');
            $table->string('type')->nullable(); // home, mobile, work, etc.
            $table->string('area_code', 3)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->integer('phone_order')->default(0); // Order for multiple phones
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_phones');
    }
};
