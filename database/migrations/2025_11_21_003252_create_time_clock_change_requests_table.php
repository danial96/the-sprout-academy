<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('time_clock_change_requests', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('location');
            $table->date('date_to_be_changed');
            $table->time('clock_in_time');
            $table->time('clock_out_for_lunch')->nullable();
            $table->time('clock_in_from_lunch')->nullable();
            $table->time('clock_out_time')->nullable();
            $table->string('reason_for_change');
            $table->string('supervisor_first_name')->nullable();
            $table->string('supervisor_last_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_clock_change_requests');
    }
};
