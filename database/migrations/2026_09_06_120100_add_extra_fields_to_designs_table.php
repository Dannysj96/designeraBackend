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
        Schema::table('designs', function (Blueprint $table) {
            $table->string('plan')->nullable();
            $table->string('frames')->nullable();
            $table->text('caption')->nullable();
            $table->string('state')->nullable();
            $table->json('city')->nullable();
            $table->json('party')->nullable();
            $table->string('display_to_user')->nullable();
            $table->string('watermark_text_color')->nullable();
            $table->date('date')->nullable();
            $table->string('up_to_days')->nullable();
            $table->boolean('only_for_today')->default(false);
            $table->integer('show_in_slider')->default(0);
            $table->string('copyright_position')->nullable();
            $table->integer('remove_watermark')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn([
                'plan',
                'frames',
                'caption',
                'state',
                'city',
                'party',
                'display_to_user',
                'watermark_text_color',
                'date',
                'up_to_days',
                'only_for_today',
                'show_in_slider',
                'copyright_position',
                'remove_watermark',
            ]);
        });
    }
};
