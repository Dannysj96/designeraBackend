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
        Schema::table('regular_notifications', function (Blueprint $table) {
            $table->string('send_status')->default('not_sent')->after('firebase_topic');
            $table->timestamp('sent_at')->nullable()->after('send_status');
            $table->text('send_error')->nullable()->after('sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regular_notifications', function (Blueprint $table) {
            $table->dropColumn(['send_status', 'sent_at', 'send_error']);
        });
    }
};
