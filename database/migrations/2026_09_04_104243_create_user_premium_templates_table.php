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
        Schema::create('user_premium_templates', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->index();
            $table->string('middle_image')->nullable();
            $table->string('top_image')->nullable();
            $table->string('bottom_image')->nullable();
            $table->string('frame_type')->default('Blank Frame');
            $table->string('status')->default('Active');
            $table->integer('up_to_days')->default(30);
            $table->integer('days_left')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_premium_templates');
    }
};
