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
        Schema::create('design_maskings', function (Blueprint $table) {
            $table->id();
            $table->string('design')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->integer('status')->default(1);
            $table->json('merging')->nullable();
            $table->string('special_day')->nullable();
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
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_maskings');
    }
};
