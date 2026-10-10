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
        if (Schema::hasTable('ready_photo')) {
            Schema::table('ready_photo', function (Blueprint $table) {
                if (!Schema::hasColumn('ready_photo', 'parent_category_id')) {
                    $table->unsignedBigInteger('parent_category_id')->nullable()->after('image');
                }
                if (!Schema::hasColumn('ready_photo', 'category_id')) {
                    $table->unsignedBigInteger('category_id')->nullable()->after('parent_category_id');
                }
            });
        }

        if (Schema::hasTable('ready_text')) {
            Schema::table('ready_text', function (Blueprint $table) {
                if (!Schema::hasColumn('ready_text', 'party')) {
                    $table->longText('party')->nullable()->after('image');
                }
                if (!Schema::hasColumn('ready_text', 'parent_category_id')) {
                    $table->unsignedBigInteger('parent_category_id')->nullable()->after('party');
                }
                if (!Schema::hasColumn('ready_text', 'category_id')) {
                    $table->unsignedBigInteger('category_id')->nullable()->after('parent_category_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('ready_photo')) {
            Schema::table('ready_photo', function (Blueprint $table) {
                $cols = array_filter(['parent_category_id', 'category_id'], fn($c) => Schema::hasColumn('ready_photo', $c));
                if (!empty($cols)) {
                    $table->dropColumn($cols);
                }
            });
        }

        if (Schema::hasTable('ready_text')) {
            Schema::table('ready_text', function (Blueprint $table) {
                $cols = array_filter(['party', 'parent_category_id', 'category_id'], fn($c) => Schema::hasColumn('ready_text', $c));
                if (!empty($cols)) {
                    $table->dropColumn($cols);
                }
            });
        }
    }
};
