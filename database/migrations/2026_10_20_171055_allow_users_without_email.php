<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('email')->nullable()->change();
        });

        DB::table('users')
            ->whereNotNull('phone')
            ->whereNotNull('email')
            ->where('email', 'like', '%@designera.shop')
            ->select(['id', 'phone', 'email'])
            ->orderBy('id')
            ->chunkById(100, function ($users): void {
                foreach ($users as $user) {
                    $phonePattern = preg_quote((string) $user->phone, '/');
                    $generatedEmailPattern = '/^'.$phonePattern.'(?:\+[a-z0-9]{8})?@designera\.shop$/i';

                    if (preg_match($generatedEmailPattern, (string) $user->email) === 1) {
                        DB::table('users')
                            ->where('id', $user->id)
                            ->update(['email' => null]);
                    }
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')
            ->whereNull('email')
            ->select(['id'])
            ->orderBy('id')
            ->chunkById(100, function ($users): void {
                foreach ($users as $user) {
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['email' => 'user-'.$user->id.'@designera.shop']);
                }
            });

        Schema::table('users', function (Blueprint $table): void {
            $table->string('email')->nullable(false)->change();
        });
    }
};
