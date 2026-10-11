<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['designs', 'design_maskings', 'videos'] as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            foreach (['views', 'downloads'] as $counterColumn) {
                if (! Schema::hasColumn($tableName, $counterColumn)) {
                    Schema::table($tableName, function (Blueprint $table) use ($counterColumn): void {
                        $table->unsignedBigInteger($counterColumn)->default(0)->index();
                    });
                }

                DB::table($tableName)->whereNull($counterColumn)->update([$counterColumn => 0]);
            }
        }

        if (! Schema::hasTable('design_views')) {
            return;
        }

        if (! Schema::hasColumn('design_views', 'design_type')) {
            Schema::table('design_views', function (Blueprint $table): void {
                $table->string('design_type', 32)->default('design')->after('id');
            });
        }

        $indexes = collect(Schema::getIndexes('design_views'));

        if ($indexes->contains(fn (array $index): bool => $index['name'] === 'unique_design_user_view')) {
            Schema::table('design_views', function (Blueprint $table): void {
                $table->dropUnique('unique_design_user_view');
            });
        }

        $indexes = collect(Schema::getIndexes('design_views'));

        if (! $indexes->contains(fn (array $index): bool => $index['name'] === 'unique_design_type_user_view')) {
            Schema::table('design_views', function (Blueprint $table): void {
                $table->unique(
                    ['design_type', 'design_id', 'user_id'],
                    'unique_design_type_user_view',
                );
            });
        }

        if (! $indexes->contains(fn (array $index): bool => $index['name'] === 'design_type_device_view_index')) {
            Schema::table('design_views', function (Blueprint $table): void {
                $table->index(
                    ['design_type', 'design_id', 'device_id'],
                    'design_type_device_view_index',
                );
            });
        }
    }

    public function down(): void
    {
        // Retain view totals and typed view history when rolling back.
    }
};
