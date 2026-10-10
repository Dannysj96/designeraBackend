<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('designs')) {
            return;
        }

        Schema::table('designs', function (Blueprint $table) {
            if (! Schema::hasColumn('designs', 'front_img')) {
                $table->boolean('front_img')->default(false)->after('merging');
            }

            if (! Schema::hasColumn('designs', 'back')) {
                $table->boolean('back')->default(false)->after('front_img');
            }
        });

        if (! Schema::hasColumn('designs', 'merging')) {
            return;
        }

        foreach (DB::table('designs')->get(['id', 'merging']) as $row) {
            $merging = is_string($row->merging)
                ? json_decode($row->merging, true)
                : $row->merging;

            if (! is_array($merging)) {
                continue;
            }

            $front = in_array('1', $merging, true)
                || in_array('front_img', $merging, true)
                || ! empty($merging['1'])
                || ! empty($merging['front_img']);
            $back = in_array('2', $merging, true)
                || in_array('back', $merging, true)
                || ! empty($merging['2'])
                || ! empty($merging['back']);

            DB::table('designs')->where('id', $row->id)->update([
                'front_img' => $front,
                'back' => $back,
            ]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('designs')) {
            return;
        }

        Schema::table('designs', function (Blueprint $table) {
            $columns = array_filter(['front_img', 'back'], fn ($column) => Schema::hasColumn('designs', $column));
            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
