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
        // 1. special_days table
        // 1. special_days table
        if (Schema::hasTable('special_days')) {
            Schema::table('special_days', function (Blueprint $table) {
                if (!Schema::hasColumn('special_days', 'date')) {
                    $table->date('date')->nullable();
                }
                if (!Schema::hasColumn('special_days', 'status')) {
                    $table->integer('status')->default(1);
                }
            });

            // Backfill only if the source columns actually exist
            if (Schema::hasColumn('special_days', 's_date')) {
                DB::statement("UPDATE special_days SET `date` = s_date WHERE `date` IS NULL AND s_date IS NOT NULL");
            }
            if (Schema::hasColumn('special_days', 'img_status')) {
                DB::statement("UPDATE special_days SET status = img_status WHERE status IS NULL");
            }
        }

        // 2. category table
        if (Schema::hasTable('category')) {
            Schema::table('category', function (Blueprint $table) {
                if (!Schema::hasColumn('category', 'status')) {
                    $table->integer('status')->default(1)->after('name');
                }
                if (!Schema::hasColumn('category', 'parent_category_id')) {
                    $table->unsignedBigInteger('parent_category_id')->nullable()->after('status');
                }
                if (!Schema::hasColumn('category', 'image')) {
                    $table->text('image')->nullable()->after('parent_category_id');
                }
            });
        }

        // 3. parent_category table
        if (Schema::hasTable('parent_category')) {
            Schema::table('parent_category', function (Blueprint $table) {
                if (!Schema::hasColumn('parent_category', 'status')) {
                    $table->integer('status')->default(1)->after('name');
                }
                if (!Schema::hasColumn('parent_category', 'image')) {
                    $table->text('image')->nullable()->after('status');
                }
            });
        }

        // 4. ready_photo table
        if (Schema::hasTable('ready_photo')) {
            Schema::table('ready_photo', function (Blueprint $table) {
                if (!Schema::hasColumn('ready_photo', 'photo')) {
                    $table->text('photo')->nullable()->after('image');
                }
            });
            DB::statement("ALTER TABLE ready_photo MODIFY image text NULL");
            DB::statement("ALTER TABLE ready_photo MODIFY party text NULL");
        }

        // 5. coupons table
        if (Schema::hasTable('coupons')) {
            DB::statement("ALTER TABLE coupons MODIFY name varchar(128) NULL DEFAULT ''");
            DB::statement("ALTER TABLE coupons MODIFY type char(1) NULL DEFAULT 'P'");
            DB::statement("ALTER TABLE coupons MODIFY total decimal(15,4) NULL DEFAULT 0.0000");
            DB::statement("ALTER TABLE coupons MODIFY discount decimal(15,4) NULL DEFAULT 0.0000");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
