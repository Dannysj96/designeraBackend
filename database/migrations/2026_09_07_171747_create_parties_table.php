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
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('symbol')->nullable();
            $table->string('state')->nullable();  
            $table->string('status')->default('pending');
            $table->json('top_templates')->nullable();
            $table->json('bottom_templates')->nullable();
            $table->string('margin_left')->nullable();
            $table->string('margin_right')->nullable();
            $table->string('margin_top')->nullable();
            $table->string('margin_bottom')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
