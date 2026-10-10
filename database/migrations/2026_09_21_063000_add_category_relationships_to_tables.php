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
        // 1. design_maskings table
        if (Schema::hasTable('design_maskings')) {
            Schema::table('design_maskings', function (Blueprint $table) {
                if (!Schema::hasColumn('design_maskings', 'parent_category_id')) {
                    $table->unsignedBigInteger('parent_category_id')->nullable()->after('merging')->index();
                }
                if (!Schema::hasColumn('design_maskings', 'category_id')) {
                    $table->unsignedBigInteger('category_id')->nullable()->after('parent_category_id')->index();
                }
                if (!Schema::hasColumn('design_maskings', 'sub_category_id')) {
                    $table->unsignedBigInteger('sub_category_id')->nullable()->after('category_id')->index();
                }
            });
        }

        // 2. sub_categories table
        if (Schema::hasTable('sub_categories')) {
            Schema::table('sub_categories', function (Blueprint $table) {
                if (!Schema::hasColumn('sub_categories', 'category_id')) {
                    $table->unsignedBigInteger('category_id')->nullable()->after('parent_category_id')->index();
                }
            });
        }

        // 3. designs table
        if (Schema::hasTable('designs')) {
            Schema::table('designs', function (Blueprint $table) {
                if (!Schema::hasColumn('designs', 'parent_category_id')) {
                    $table->unsignedBigInteger('parent_category_id')->nullable()->after('category_id')->index();
                }
                if (!Schema::hasColumn('designs', 'sub_category_id')) {
                    $table->unsignedBigInteger('sub_category_id')->nullable()->after('parent_category_id')->index();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('design_maskings')) {
            Schema::table('design_maskings', function (Blueprint $table) {
                $columns = array_filter(['parent_category_id', 'category_id', 'sub_category_id'], fn($c) => Schema::hasColumn('design_maskings', $c));
                if (!empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }

        if (Schema::hasTable('sub_categories')) {
            Schema::table('sub_categories', function (Blueprint $table) {
                if (Schema::hasColumn('sub_categories', 'category_id')) {
                    $table->dropColumn('category_id');
                }
            });
        }

        if (Schema::hasTable('designs')) {
            Schema::table('designs', function (Blueprint $table) {
                $columns = array_filter(['parent_category_id', 'sub_category_id'], fn($c) => Schema::hasColumn('designs', $c));
                if (!empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
