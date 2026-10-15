<?php

namespace Tests\Feature;

use App\Models\Coupon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CouponListApiTest extends TestCase
{
    public function test_coupon_list_returns_only_active_visible_coupons_with_current_dates(): void
    {
        $this->freezeTime();
        $this->createCouponsTable();

        $this->createCoupon('CURRENT-ACTIVE');
        $this->createCoupon('INACTIVE', status: 'deactive');
        $this->createCoupon('HIDDEN', isDisplay: false);
        $this->createCoupon('NOT-STARTED', startDate: now()->addDay()->toDateString());
        $this->createCoupon('EXPIRED', endDate: now()->subDay()->toDateString());

        $this->getJson('/api/v1/coupons')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.code', 'CURRENT-ACTIVE');
    }

    public function test_coupon_validation_rejects_hidden_coupons(): void
    {
        $this->freezeTime();
        $this->createCouponsTable();
        $this->createCoupon('HIDDEN', isDisplay: false);

        $this->postJson('/api/v1/coupons/validate', ['code' => 'HIDDEN'])
            ->assertNotFound()
            ->assertJsonPath('status', 'error');
    }

    private function createCouponsTable(): void
    {
        Schema::dropIfExists('coupons');
        Schema::create('coupons', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('type');
            $table->integer('total')->nullable();
            $table->decimal('discount', 10, 2);
            $table->decimal('max_discount', 10, 2)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_uses')->default(0);
            $table->integer('use_per_user')->default(1);
            $table->string('status');
            $table->boolean('is_display')->default(true);
            $table->json('user_type')->nullable();
            $table->timestamps();
        });
    }

    private function createCoupon(
        string $code,
        string $status = 'active',
        bool $isDisplay = true,
        ?string $startDate = null,
        ?string $endDate = null,
    ): Coupon {
        return Coupon::query()->create([
            'name' => $code,
            'code' => $code,
            'type' => 'fixed',
            'total' => 100,
            'discount' => 20,
            'max_discount' => 20,
            'start_date' => $startDate ?? now()->subDay()->toDateString(),
            'end_date' => $endDate ?? now()->addDay()->toDateString(),
            'total_uses' => 0,
            'use_per_user' => 1,
            'status' => $status,
            'is_display' => $isDisplay,
        ]);
    }
}
