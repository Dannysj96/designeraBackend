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
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('parent_category_id')->nullable()->after('id')->constrained('parent_categories')->nullOnDelete();
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('parent_category_id')->constrained('categories')->nullOnDelete();
        });

        Schema::table('design_maskings', function (Blueprint $table) {
            $table->foreignId('parent_category_id')->nullable()->after('merging')->constrained('parent_categories')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->after('parent_category_id')->constrained('categories')->nullOnDelete();
            $table->foreignId('sub_category_id')->nullable()->after('category_id')->constrained('sub_categories')->nullOnDelete();
        });

        Schema::table('designs', function (Blueprint $table) {
            $table->foreignId('parent_category_id')->nullable()->after('merging')->constrained('parent_categories')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->after('parent_category_id')->constrained('categories')->nullOnDelete();
            $table->foreignId('sub_category_id')->nullable()->after('category_id')->constrained('sub_categories')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->dropForeign(['parent_category_id']);
            $table->dropForeign(['category_id']);
            $table->dropForeign(['sub_category_id']);
            $table->dropColumn(['parent_category_id', 'category_id', 'sub_category_id']);
        });

        Schema::table('design_maskings', function (Blueprint $table) {
            $table->dropForeign(['parent_category_id']);
            $table->dropForeign(['category_id']);
            $table->dropForeign(['sub_category_id']);
            $table->dropColumn(['parent_category_id', 'category_id', 'sub_category_id']);
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_category_id']);
            $table->dropColumn(['parent_category_id']);
        });
    }
};
