<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('child_absent_forms', function (Blueprint $table) {
            $table->date('date_submission')->nullable()->after('phone_number');
            
            $table->string('child_first_name')->nullable()->after('last_name');
            $table->string('child_last_name')->nullable()->after('child_first_name');
        });
        
        if (Schema::hasColumn('child_absent_forms', 'child_name')) {
            DB::statement("UPDATE child_absent_forms SET child_first_name = COALESCE(child_first_name, child_name), child_last_name = COALESCE(child_last_name, '') WHERE child_name IS NOT NULL");
            
            Schema::table('child_absent_forms', function (Blueprint $table) {
                $table->dropColumn('child_name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('child_absent_forms', function (Blueprint $table) {
            $table->string('child_name')->nullable()->after('last_name');
        });
        
        if (Schema::hasColumn('child_absent_forms', 'child_first_name')) {
            DB::statement("UPDATE child_absent_forms SET child_name = TRIM(CONCAT(COALESCE(child_first_name, ''), ' ', COALESCE(child_last_name, ''))) WHERE child_name IS NULL OR child_name = ''");
        }
        
        Schema::table('child_absent_forms', function (Blueprint $table) {
            $table->dropColumn(['date_submission', 'child_first_name', 'child_last_name']);
        });
    }
};
