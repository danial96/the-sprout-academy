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
        Schema::table('locations', function (Blueprint $table) {
            $table->boolean('show_schedule_tour')->default(true)->after('home_page_image');
            $table->boolean('show_enroll')->default(true)->after('show_schedule_tour');
        });
    }

    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn(['show_schedule_tour', 'show_enroll']);
        });
    }
};
