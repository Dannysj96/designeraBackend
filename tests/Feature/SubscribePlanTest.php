<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SubscribePlanTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('user_plan_histories');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->string('plan_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->boolean('plan_expired')->default(false);
            $table->integer('design_daily_download_limit')->default(20);
            $table->integer('video_daily_download_limit')->default(10);
            $table->decimal('wallet_balance', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('plans', function (Blueprint $table): void {
            $table->id();
            $table->integer('parent_id')->default(0);
            $table->string('name', 50)->nullable();
            $table->text('image')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('duration')->nullable();
            $table->integer('is_display')->nullable()->default(0);
            $table->integer('status')->default(0);
            $table->integer('area')->nullable()->default(0);
            $table->integer('photos')->nullable()->default(0);
            $table->integer('daily_design_limit')->default(0);
            $table->integer('daily_video_limit')->default(0);
            $table->text('app_key')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('user_plan_histories', function (Blueprint $table): void {
            $table->id();
            $table->integer('user_id')->index();
            $table->integer('plan_id')->nullable()->index();
            $table->string('plan_name');
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('duration_days')->default(30);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('status')->default('active');
            $table->integer('daily_limit_design')->default(0);
            $table->integer('daily_limit_video')->default(0);
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function test_authenticated_user_pays_for_plan_and_user_plan_history_are_updated(): void
    {
        $user = User::factory()->create();
        DB::table('users')->where('id', $user->id)->update(['wallet_balance' => 1200]);
        $planId = $this->createPlan(price: 999, designLimit: 8, videoLimit: 2);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/auth/subscribe-plan', [
            'plan_id' => $planId,
        ]);

        $response->assertCreated()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('balance', 201)
            ->assertJsonPath('user.start_date', now()->format('d M Y h:i a'))
            ->assertJsonPath('user.expiry_date', now()->addDays(30)->format('d M Y h:i a'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'plan_id' => (string) $planId,
            'wallet_balance' => 201,
            'design_daily_download_limit' => 8,
            'video_daily_download_limit' => 2,
            'plan_expired' => false,
        ]);
        $this->assertDatabaseHas('user_plan_histories', [
            'user_id' => $user->id,
            'plan_id' => $planId,
            'price' => 999,
            'daily_limit_design' => 8,
            'daily_limit_video' => 2,
            'payment_method' => 'wallet',
            'status' => 'active',
        ]);
    }

    public function test_subscription_is_rejected_without_charging_or_changing_plan_when_wallet_is_insufficient(): void
    {
        $user = User::factory()->create();
        DB::table('users')->where('id', $user->id)->update(['wallet_balance' => 75]);
        $planId = $this->createPlan(price: 999, designLimit: 8, videoLimit: 2);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/auth/subscribe-plan', [
            'plan_id' => $planId,
        ]);

        $response->assertPaymentRequired()
            ->assertJsonPath('status', 'insufficient_balance')
            ->assertJsonPath('balance', 75)
            ->assertJsonPath('required_amount', 999);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'plan_id' => null,
            'wallet_balance' => 75,
        ]);
        $this->assertDatabaseCount('user_plan_histories', 0);
    }

    public function test_expired_subscription_updates_the_user_flag_and_history_status(): void
    {
        $user = User::factory()->create();
        DB::table('users')->where('id', $user->id)->update([
            'plan_id' => '22',
            'expiry_date' => now()->subDay()->toDateString(),
            'plan_expired' => false,
        ]);
        DB::table('user_plan_histories')->insert([
            'user_id' => $user->id,
            'plan_id' => 22,
            'plan_name' => 'Expired Plan',
            'price' => 100,
            'duration_days' => 30,
            'start_date' => now()->subDays(31),
            'end_date' => now()->subDay(),
            'status' => 'active',
            'daily_limit_design' => 5,
            'daily_limit_video' => 1,
            'payment_method' => 'wallet',
            'created_at' => now()->subDays(31),
            'updated_at' => now()->subDays(31),
        ]);

        $this->actingAs($user->fresh(), 'sanctum')->getJson('/api/v1/auth/me')
            ->assertOk()
            ->assertJsonPath('user.plan_expired', true);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'plan_expired' => true]);
        $this->assertDatabaseHas('user_plan_histories', [
            'user_id' => $user->id,
            'status' => 'expired',
        ]);
    }

    public function test_design_and_video_downloads_use_separate_active_plan_quotas(): void
    {
        $this->createDownloadTables();

        $user = User::factory()->create();
        DB::table('user_plan_histories')->insert([
            'user_id' => $user->id,
            'plan_id' => 1,
            'plan_name' => 'Quota Plan',
            'price' => 0,
            'duration_days' => 30,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'status' => 'active',
            'daily_limit_design' => 1,
            'daily_limit_video' => 1,
            'payment_method' => 'wallet',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('designs')->insert([
            ['id' => 1, 'design' => 'design.jpg', 'price' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('videos')->insert([
            'id' => 2,
            'video' => 'video.mp4',
            'price' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($user, 'sanctum')->postJson('/api/v1/designs/1/download', [
            'view_type' => 'image',
        ])->assertOk()->assertJsonPath('status', 'success');
        $this->postJson('/api/v1/designs/2/download', [
            'view_type' => 'video',
        ])->assertOk()->assertJsonPath('status', 'success');
        $this->postJson('/api/v1/designs/2/download', [
            'view_type' => 'video',
        ])->assertJsonPath('status', 'limit_reached')
            ->assertJsonPath('daily_limit', 1)
            ->assertJsonPath('downloads_today', 1);

        $this->assertDatabaseCount('photo_history', 2);
        $this->assertDatabaseHas('photo_history', ['photo_id' => 1, 'type' => 'design']);
        $this->assertDatabaseHas('photo_history', ['photo_id' => 2, 'type' => 'video']);
    }

    public function test_limit_prompt_then_wallet_payment_deducts_and_records_download(): void
    {
        $this->createDownloadTables();
        $user = User::factory()->create();
        DB::table('users')->where('id', $user->id)->update(['wallet_balance' => 100]);
        $this->createActiveQuotaHistory($user);
        DB::table('designs')->insert([
            'id' => 1,
            'design' => 'design.jpg',
            'price' => 15,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($user, 'sanctum')->postJson('/api/v1/designs/1/download')
            ->assertOk()
            ->assertJsonPath('status', 'success');
        $this->postJson('/api/v1/designs/1/download')
            ->assertOk()
            ->assertJsonPath('status', 'limit_reached')
            ->assertJsonPath('downloads_today', 1);
        $this->postJson('/api/v1/designs/1/download', ['use_wallet' => 1])
            ->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('wallet_deducted', true)
            ->assertJsonPath('amount_deducted', 15)
            ->assertJsonPath('balance', 85);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'wallet_balance' => 85]);
        $this->assertDatabaseCount('photo_history', 2);
        $this->assertDatabaseHas('photo_history', [
            'user_id' => $user->id,
            'photo_id' => 1,
            'photo_price' => 15,
            'type' => 'design',
        ]);
        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'amount' => -15,
            'type' => 'debit',
        ]);
    }

    public function test_insufficient_wallet_balance_returns_402_without_charging_or_recording_download(): void
    {
        $this->createDownloadTables();
        $user = User::factory()->create();
        DB::table('users')->where('id', $user->id)->update(['wallet_balance' => 10]);
        $this->createActiveQuotaHistory($user);
        DB::table('designs')->insert([
            ['id' => 1, 'design' => 'first.jpg', 'price' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'design' => 'second.jpg', 'price' => 25, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $this->actingAs($user, 'sanctum')->postJson('/api/v1/designs/1/download')
            ->assertOk()
            ->assertJsonPath('status', 'success');
        $this->postJson('/api/v1/designs/2/download', ['use_wallet' => 1])
            ->assertPaymentRequired()
            ->assertJsonPath('status', 'insufficient_balance')
            ->assertJsonPath('wallet_balance', 10)
            ->assertJsonPath('required_amount', 25);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'wallet_balance' => 10]);
        $this->assertDatabaseCount('photo_history', 1);
        $this->assertDatabaseMissing('photo_history', ['photo_id' => 2]);
        $this->assertDatabaseCount('transactions', 0);
    }

    private function createDownloadTables(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('photo_history');
        Schema::dropIfExists('videos');
        Schema::dropIfExists('designs');

        Schema::create('designs', function (Blueprint $table): void {
            $table->id();
            $table->string('design')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('views')->default(0);
            $table->integer('downloads')->default(0);
            $table->timestamps();
        });
        Schema::create('videos', function (Blueprint $table): void {
            $table->id();
            $table->string('video')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('views')->default(0);
            $table->integer('downloads')->default(0);
            $table->timestamps();
        });
        Schema::create('photo_history', function (Blueprint $table): void {
            $table->id();
            $table->integer('user_id');
            $table->integer('photo_id');
            $table->string('app_key')->nullable();
            $table->decimal('photo_price', 10, 2)->default(0);
            $table->string('type');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('pincode')->nullable();
            $table->timestamps();
        });
        Schema::create('transactions', function (Blueprint $table): void {
            $table->id();
            $table->integer('user_id');
            $table->decimal('amount', 10, 2);
            $table->string('currency');
            $table->string('type');
            $table->string('payment_method');
            $table->string('description');
            $table->timestamps();
        });
    }

    private function createActiveQuotaHistory(User $user): void
    {
        DB::table('user_plan_histories')->insert([
            'user_id' => $user->id,
            'plan_id' => 1,
            'plan_name' => 'Quota Plan',
            'price' => 0,
            'duration_days' => 30,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'status' => 'active',
            'daily_limit_design' => 1,
            'daily_limit_video' => 1,
            'payment_method' => 'wallet',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createPlan(float $price, int $designLimit, int $videoLimit): int
    {
        return DB::table('plans')->insertGetId([
            'name' => 'Premium Plan',
            'daily_design_limit' => $designLimit,
            'daily_video_limit' => $videoLimit,
            'price' => $price,
            'duration' => 30,
            'status' => 1,
            'is_display' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
