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
        Schema::table('user_premium_templates', function (Blueprint $table) {
            $table->date('created_date')->nullable()->after('status');
            $table->integer('extra_days')->default(0)->after('up_to_days');
            $table->integer('margin_bottom')->default(0)->after('extra_days');
            $table->integer('margin_top')->default(0)->after('margin_bottom');
            $table->integer('margin_left')->default(0)->after('margin_top');
            $table->integer('margin_right')->default(0)->after('margin_left');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_premium_templates', function (Blueprint $table) {
            $table->dropColumn([
                'created_date',
                'extra_days',
                'margin_bottom',
                'margin_top',
                'margin_left',
                'margin_right',
            ]);
        });
    }
};
