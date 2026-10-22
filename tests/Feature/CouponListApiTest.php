<?php

namespace Tests\Feature;

use App\Models\Coupon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CouponListApiTest extends TestCase
{
    public function test_coupon_list_returns_only_active_visible_coupons_with_current_dates(): void
    {
        $this->freezeTime();
        $this->createCouponsTable();

        $this->createCoupon('CURRENT-ACTIVE');
        $this->createCoupon('INACTIVE', status: 0);
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

    public function test_wallet_top_up_charges_coupon_discount_and_records_full_credit_amount(): void
    {
        config([
            'services.razorpay.key' => 'test_key',
            'services.razorpay.secret' => 'test_secret',
        ]);
        $this->createCouponsTable();
        $this->createCoupon('SAVE20');
        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->decimal('balance', 10, 2)->default(0);
            $table->timestamps();
        });
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Wallet User',
            'email' => 'wallet@example.test',
            'password' => 'password',
            'balance' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Schema::create('wallet_payments', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('razorpay_order_id', 64)->unique();
            $table->string('razorpay_payment_id', 64)->nullable()->unique();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('INR');
            $table->string('status', 20)->default('created');
            $table->json('gateway_order_data')->nullable();
            $table->json('gateway_payment_data')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
        Schema::create('transactions', function (Blueprint $table): void {
            $table->id();
            $table->string('user_id');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3);
            $table->string('type');
            $table->string('payment_method');
            $table->string('description');
            $table->json('payu_data')->nullable();
            $table->timestamps();
        });
        Http::fake([
            'https://api.razorpay.com/v1/orders' => Http::response([
                'id' => 'order_test_123',
            ]),
            'https://api.razorpay.com/v1/payments/pay_test_123' => Http::response([
                'id' => 'pay_test_123',
                'order_id' => 'order_test_123',
                'status' => 'captured',
                'amount' => 8000,
                'currency' => 'INR',
                'method' => 'upi',
            ]),
        ]);

        $this->postJson('/api/v1/razorpay_integration', [
            'amount' => 49,
            'user_id' => 1,
        ])->assertUnprocessable()
            ->assertJsonValidationErrors('amount');

        $this->assertDatabaseCount('wallet_payments', 0);

        $this->postJson('/api/v1/razorpay_integration', [
            'amount' => 100,
            'coupon_code' => 'SAVE20',
            'user_id' => 1,
        ])->assertOk()
            ->assertJsonPath('data.amount', 80)
            ->assertJsonPath('data.credit_amount', 100)
            ->assertJsonPath('data.coupon_code', 'SAVE20');

        $this->assertDatabaseHas('wallet_payments', [
            'razorpay_order_id' => 'order_test_123',
            'amount' => '80.00',
        ]);
        $gatewayOrderData = json_decode(
            (string) DB::table('wallet_payments')->value('gateway_order_data'),
            true,
        );
        $this->assertSame(10000, $gatewayOrderData['credit_amount']);

        $signature = hash_hmac('sha256', 'order_test_123|pay_test_123', 'test_secret');
        $this->postJson('/api/v1/razorpay_verification', [
            'razorpay_order_id' => 'order_test_123',
            'razorpay_payment_id' => 'pay_test_123',
            'razorpay_signature' => $signature,
            'user_id' => 1,
        ])->assertOk()
            ->assertJsonPath('amount_credited', 100);

        $this->assertDatabaseHas('users', ['id' => 1, 'balance' => '100.00']);
        $this->assertDatabaseHas('transactions', [
            'user_id' => '1',
            'amount' => '100.00',
            'type' => 'credit',
        ]);
    }

    private function createCouponsTable(): void
    {
        Schema::dropIfExists('coupons');
        Schema::create('coupons', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->char('type', 1);
            $table->integer('total')->nullable();
            $table->decimal('discount', 10, 2);
            $table->decimal('max_discount', 10, 2)->nullable();
            $table->date('date_start');
            $table->date('date_end');
            $table->integer('uses_total')->default(0);
            $table->integer('uses_customer')->default(1);
            $table->integer('status')->default(0);
            $table->boolean('is_display')->default(true);
            $table->json('user_type')->nullable();
            $table->timestamps();
        });
    }

    private function createCoupon(
        string $code,
        int $status = 1,
        bool $isDisplay = true,
        ?string $startDate = null,
        ?string $endDate = null,
    ): Coupon {
        return Coupon::query()->create([
            'name' => $code,
            'code' => $code,
            'type' => 'F',
            'total' => 100,
            'discount' => 20,
            'max_discount' => 20,
            'date_start' => $startDate ?? now()->subDay()->toDateString(),
            'date_end' => $endDate ?? now()->addDay()->toDateString(),
            'uses_total' => 0,
            'uses_customer' => 1,
            'status' => $status,
            'is_display' => $isDisplay,
        ]);
    }
}
