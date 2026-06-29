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
        Schema::table('time_off_requests', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('director_signature');
            $table->unsignedBigInteger('approved_by')->nullable()->after('status');
            $table->unsignedBigInteger('rejected_by')->nullable()->after('approved_by');
            $table->timestamp('approved_at')->nullable()->after('rejected_by');
            $table->timestamp('rejected_at')->nullable()->after('approved_at');
            $table->text('rejection_reason')->nullable()->after('rejected_at');

            // Foreign keys (optional - if you have users table)
            // $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_off_requests', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'approved_by',
                'rejected_by',
                'approved_at',
                'rejected_at',
                'rejection_reason'
            ]);
        });
    }
};


