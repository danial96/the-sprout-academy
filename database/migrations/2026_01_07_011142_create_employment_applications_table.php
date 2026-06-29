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
        Schema::create('employment_applications', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->string('location');
            $table->date('start_date')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('salary_dollars')->nullable();
            $table->string('salary_cents')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employment_applications');
    }
};
