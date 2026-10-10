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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo')->nullable()->after('id');
            $table->string('mobile')->nullable()->after('email');
            $table->string('state')->nullable()->after('mobile');
            $table->string('city')->nullable()->after('state');
            $table->string('party')->nullable()->after('city');
            $table->string('designation_1')->nullable()->after('party');
            $table->string('designation_2')->nullable()->after('designation_1');
            $table->string('whatsapp')->nullable()->after('designation_2');
            $table->string('facebook')->nullable()->after('whatsapp');
            $table->string('twitter')->nullable()->after('facebook');
            $table->string('instagram')->nullable()->after('twitter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_photo',
                'mobile',
                'state',
                'city',
                'party',
                'designation_1',
                'designation_2',
                'whatsapp',
                'facebook',
                'twitter',
                'instagram',
            ]);
        });
    }
};
