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
        Schema::create('ready_photos', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->json('party')->nullable();
            $table->integer('sort_order')->default(0);
            $table->integer('status')->default(1);
            $table->foreignId('parent_category_id')->nullable()->constrained('parent_categories')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ready_photos');
    }
};
