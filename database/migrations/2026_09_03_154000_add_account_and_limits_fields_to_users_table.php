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
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default('active')->after('password');
            $table->boolean('remove_copyright')->default(false)->after('status');
            $table->boolean('remove_watermark')->default(false)->after('remove_copyright');
            $table->string('language')->default('en')->after('remove_watermark');
            $table->integer('daily_download_limit_video')->default(10)->after('language');
            $table->integer('daily_download_limit_design')->default(20)->after('daily_download_limit_video');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'remove_copyright',
                'remove_watermark',
                'language',
                'daily_download_limit_video',
                'daily_download_limit_design',
            ]);
        });
    }
};
