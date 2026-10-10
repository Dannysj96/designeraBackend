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
        Schema::create('user_plan_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->integer('plan_id')->nullable()->index();
            $table->string('plan_name');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->integer('duration_days')->default(30);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('status')->default('active'); // active, expired, upgraded, cancelled
            $table->integer('daily_limit_design')->default(0);
            $table->integer('daily_limit_video')->default(0);
            $table->string('payment_method')->nullable()->default('admin'); // admin, razorpay, wallet, free_trial
            $table->string('transaction_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_plan_histories');
    }
};
