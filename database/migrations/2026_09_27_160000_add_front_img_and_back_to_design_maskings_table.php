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
        if (Schema::hasTable('design_maskings')) {
            Schema::table('design_maskings', function (Blueprint $table) {
                if (!Schema::hasColumn('design_maskings', 'front_img')) {
                    $table->boolean('front_img')->default(false)->after('merging');
                }
                if (!Schema::hasColumn('design_maskings', 'back')) {
                    $table->boolean('back')->default(false)->after('front_img');
                }
            });

            // Backfill front_img and back based on existing merging data
            try {
                $rows = DB::table('design_maskings')->get(['id', 'merging']);
                foreach ($rows as $row) {
                    if (empty($row->merging)) continue;
                    $m = json_decode($row->merging, true);
                    if (!is_array($m)) continue;
                    $front = in_array('1', $m) || in_array('front_img', $m) || !empty($m['1']) || !empty($m['front_img']);
                    $back = in_array('2', $m) || in_array('back', $m) || !empty($m['2']) || !empty($m['back']);
                    if ($front || $back) {
                        DB::table('design_maskings')->where('id', $row->id)->update([
                            'front_img' => $front,
                            'back' => $back,
                        ]);
                    }
                }
            } catch (\Throwable $e) {
                // Ignore backfill errors if any
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('design_maskings')) {
            Schema::table('design_maskings', function (Blueprint $table) {
                if (Schema::hasColumn('design_maskings', 'front_img')) {
                    $table->dropColumn('front_img');
                }
                if (Schema::hasColumn('design_maskings', 'back')) {
                    $table->dropColumn('back');
                }
            });
        }
    }
};
