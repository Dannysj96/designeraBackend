<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('special_days')) {
            Schema::table('special_days', function (Blueprint $table) {
                if (!Schema::hasColumn('special_days', 'sequence')) {
                    $table->integer('sequence')->default(0)->after('status');
                }
            });

            // Backfill sequence from is_priority if available
            try {
                DB::statement("UPDATE special_days SET sequence = is_priority WHERE (sequence IS NULL OR sequence = 0) AND is_priority > 0");
            } catch (\Throwable $e) {
                // Ignore if is_priority doesn't exist
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('special_days')) {
            Schema::table('special_days', function (Blueprint $table) {
                if (Schema::hasColumn('special_days', 'sequence')) {
                    $table->dropColumn('sequence');
                }
            });
        }
    }
};
