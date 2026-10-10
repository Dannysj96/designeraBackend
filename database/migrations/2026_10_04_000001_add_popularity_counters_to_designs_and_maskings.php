<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['designs', 'design_maskings'] as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (! Schema::hasColumn($tableName, 'views')) {
                    $table->unsignedBigInteger('views')->default(0)->index();
                }

                if (! Schema::hasColumn($tableName, 'downloads')) {
                    $table->unsignedBigInteger('downloads')->default(0)->index();
                }
            });
        }

        if (Schema::hasTable('design_views') && ! Schema::hasColumn('design_views', 'design_type')) {
            Schema::table('design_views', function (Blueprint $table) {
                $table->string('design_type', 32)->default('design')->after('id');
            });

            Schema::table('design_views', function (Blueprint $table) {
                $table->dropUnique('unique_design_user_view');
                $table->unique(
                    ['design_type', 'design_id', 'user_id'],
                    'unique_design_type_user_view',
                );
                $table->index(['design_type', 'design_id', 'device_id'], 'design_type_device_view_index');
            });
        }
    }

    public function down(): void
    {
        // Keep collected popularity metrics and typed view history during rollbacks.
    }
};
