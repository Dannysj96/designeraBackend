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
        Schema::table('videos', function (Blueprint $table) {
            if (!Schema::hasColumn('videos', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('video');
            }
            if (!Schema::hasColumn('videos', 'merging')) {
                $table->json('merging')->nullable()->after('status');
            }
            if (!Schema::hasColumn('videos', 'plan')) {
                $table->string('plan')->nullable()->after('language');
            }
            if (!Schema::hasColumn('videos', 'frames')) {
                $table->string('frames')->nullable()->after('frame_type');
            }
            if (!Schema::hasColumn('videos', 'date')) {
                $table->date('date')->nullable()->after('last_date');
            }
            if (!Schema::hasColumn('videos', 'remove_watermark')) {
                $table->integer('remove_watermark')->default(0)->after('copyright_position');
            }
            if (!Schema::hasColumn('videos', 'watermark_text_color')) {
                $table->string('watermark_text_color')->nullable()->after('caption');
            }
            if (!Schema::hasColumn('videos', 'parent_category_id')) {
                $table->unsignedBigInteger('parent_category_id')->nullable()->after('category_id');
            }
            if (!Schema::hasColumn('videos', 'sub_category_id')) {
                $table->unsignedBigInteger('sub_category_id')->nullable()->after('parent_category_id');
            }
            if (!Schema::hasColumn('videos', 'display_to_user')) {
                $table->string('display_to_user')->nullable();
            }
            if (!Schema::hasColumn('videos', 'only_for_today')) {
                $table->boolean('only_for_today')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $cols = ['thumbnail', 'merging', 'plan', 'frames', 'date', 'remove_watermark', 'watermark_text_color', 'parent_category_id', 'sub_category_id', 'display_to_user', 'only_for_today'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('videos', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
