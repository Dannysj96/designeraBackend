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
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'site_title',
                'site_subtitle',
                'logo',
                'email',
            ]);
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->string('key')->unique()->after('id');
            $table->text('value')->nullable()->after('key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['key', 'value']);
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->string('site_title')->default('Shadcnblocks Admin Kit');
            $table->string('site_subtitle')->nullable()->default('Nextjs + shadcn/ui');
            $table->string('logo')->nullable();
            $table->string('email')->default('admin@admin.com');
        });
    }
};
