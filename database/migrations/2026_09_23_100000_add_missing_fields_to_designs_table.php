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
        Schema::table('designs', function (Blueprint $table) {
            if (!Schema::hasColumn('designs', 'plan')) {
                $table->string('plan')->nullable()->after('sub_category_id');
            }
            if (!Schema::hasColumn('designs', 'frames')) {
                $table->string('frames')->nullable()->after('frame_type');
            }
            if (!Schema::hasColumn('designs', 'display_to_user')) {
                $table->string('display_to_user')->nullable()->after('party');
            }
            if (!Schema::hasColumn('designs', 'watermark_text_color')) {
                $table->string('watermark_text_color')->nullable()->after('caption');
            }
            if (!Schema::hasColumn('designs', 'only_for_today')) {
                $table->boolean('only_for_today')->default(false)->after('up_to_days');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $cols = ['plan', 'frames', 'display_to_user', 'watermark_text_color', 'only_for_today'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('designs', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
