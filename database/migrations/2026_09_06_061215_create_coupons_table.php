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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', ['fixed', 'percentage'])->default('fixed');
            $table->integer('total')->nullable();
            $table->decimal('discount', 10, 2);
            $table->decimal('max_discount', 10, 2)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_uses')->default(0);
            $table->integer('use_per_user')->default(1);
            $table->enum('status', ['active', 'deactive'])->default('active');
            $table->boolean('is_display')->default(true);
            $table->json('user_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
