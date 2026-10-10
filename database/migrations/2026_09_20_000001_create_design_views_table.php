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
        if (! Schema::hasTable('design_views')) {
            Schema::create('design_views', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('design_id')->index();
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->string('device_id', 100)->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->timestamps();

                $table->unique(['design_id', 'user_id'], 'unique_design_user_view');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_views');
    }
};
