<?php

use App\Helpers\FileManager;
use App\Models\Ads;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Design;
use App\Models\DesignMasking;
use App\Models\DesignView;
use App\Models\Location;
use App\Models\ParentCategory;
use App\Models\Party;
use App\Models\PhotoHistory;
use App\Models\Plan;
use App\Models\ReadyPhoto;
use App\Models\ReadyText;
use App\Models\RegularNotification;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\SpecialDay;
use App\Models\StaticNotification;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserDeviceToken;
use App\Models\UserPlanHistory;
use App\Models\UserPremiumTemplate;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\PersonalAccessToken;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| All routes are grouped with the 'v1' prefix and standard JSON responses.
|
*/

Route::prefix('v1')->group(function () {

    Route::get('/media', function (Request $request) {
        $validated = $request->validate([
            'path' => ['required', 'string', 'max:1024'],
        ]);

        $path = str_replace('\\', '/', $validated['path']);
        $segments = explode('/', $path);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        abort_if(
            str_starts_with($path, '/') ||
                collect($segments)->contains(fn (string $segment): bool => in_array($segment, ['', '.', '..'], true)) ||
                ! in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif', 'mp4', 'webm', 'mov', 'avi'], true),
            404,
        );

        $disk = Storage::disk('public');
        if (! $disk->exists($path)) {
            if (str_starts_with($path, '_thumbnails/')) {
                $originalPath = substr($path, strlen('_thumbnails/'));
                abort_unless($disk->exists($originalPath), 404);
                $path = $originalPath;
            } else {
                $thumbnailPath = FileManager::getThumbnailPath($path);
                abort_unless($disk->exists($thumbnailPath), 404);
                $path = $thumbnailPath;
            }
        }

        return response()->file($disk->path($path), [
            'Cache-Control' => 'public, max-age=86400',
            'Content-Disposition' => 'inline',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    })->name('api.v1.media');

    // ==========================================
    // 1. System Health & Settings
    // ==========================================
    Route::get('/health', function () {
        return response()->json([
            'status' => 'success',
            'message' => 'Designera API is healthy and running',
            'timestamp' => now()->toIso8601String(),
            'version' => '1.0.0',
        ]);
    });

    Route::get('/settings', function () {
        $settings = Setting::currentArray();
        foreach (['logo', 'watermark', 'splash_screen'] as $imageKey) {
            if (filled($settings[$imageKey] ?? null)) {
                $settings[$imageKey] = FileManager::publicThumbnailUrl($settings[$imageKey]);
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $settings,
        ]);
    });

    // ==========================================
    // 2. Locations (States & Cities)
    // ==========================================
    Route::get('/locations/states', function () {
        $states = Location::where('state_id', 0)->orderBy('name')->get(['id', 'name']);

        return response()->json([
            'status' => 'success',
            'count' => $states->count(),
            'data' => $states,
        ]);
    });

    Route::get('/locations/cities', function (Request $request) {
        $query = Location::where('state_id', '>', 0);
        if ($request->filled('state_id')) {
            $query->where('state_id', $request->input('state_id'));
        }
        $cities = $query->orderBy('name')->get(['id', 'name', 'state_id']);

        return response()->json([
            'status' => 'success',
            'count' => $cities->count(),
            'data' => $cities,
        ]);
    });

    Route::get('/languages', function () {
        $languages = collect(config('constants.languages', []))
            ->map(fn (string $name, string $id): array => [
                'id' => $id,
                'name' => $name,
            ])
            ->values();

        return response()->json([
            'status' => 'success',
            'count' => $languages->count(),
            'data' => $languages,
        ]);
    });

    // Dashboard home listing used by the Flutter app.
    Route::post('/home_listing', function (Request $request) {
        $request->validate([
            'app_key' => ['required', 'string', 'max:50'],
        ]);

        $parentCategories = ParentCategory::query()
            ->where('status', 1)
            ->with(['categories' => function ($query) {
                $query->where('status', 1)->orderBy('id');
            }])
            ->orderByRaw('CASE WHEN sequence > 0 THEN sequence ELSE 999999 END ASC')
            ->orderBy('id')
            ->get();

        $data = $parentCategories->map(function (ParentCategory $parentCategory): array {
            $name = (string) $parentCategory->name;
            $normalizedName = Str::lower($name);
            $redirectKey = match ($normalizedName) {
                'special days' => 'special_day',
                'design editor' => 'design_editor',
                'political design' => 'political_design',
                'good thought. सुविचार' => 'good_thought',
                'best quote' => 'motivational_quote',
                default => Str::slug($name, '_'),
            };

            return [
                'id' => $parentCategory->id,
                'title' => $name,
                'redirect_key' => $redirectKey,
                'images' => [],
                'category' => $parentCategory->categories
                    ->map(fn (Category $category): array => [
                        'id' => $category->id,
                        'name' => (string) $category->name,
                    ])
                    ->values(),
            ];
        })->values();

        return response()->json([
            'status' => true,
            'count' => $data->count(),
            'data' => $data,
        ]);
    });

    // ==========================================
    // 3. Authentication & User Profile (Token Based - Sanctum)
    // ==========================================

    /**
     * User Login (Email or Mobile + Password) -> returns Bearer Token
     */
    Route::post('/auth/login', function (Request $request) {
        $request->validate([
            'login' => 'required|string', // can be email or mobile/phone
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $user = User::where('email', $login)
            ->orWhere('phone', $login)
            ->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid login credentials.',
            ], 401);
        }

        if ($user->status !== null && (int) $user->status === 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Your account is deactivated. Please contact support.',
            ], 403);
        }

        // Generate Sanctum plainTextToken
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'token_type' => 'Bearer',
            'token' => $token,
            'user' => $user->load('plan'),
        ]);
    });

    /**
     * User Registration -> returns Bearer Token
     */
    Route::post('/auth/register', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'party' => 'nullable|string',
        ]);

        if (isset($validated['mobile'])) {
            $validated['phone'] = $validated['mobile'];
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = 1;

        $user = User::create($validated);
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'token_type' => 'Bearer',
            'token' => $token,
            'user' => $user,
        ], 201);
    });

    /**
     * Mobile OTP Login / Quick Login
     */
    Route::post('/auth/otp-login', function (Request $request) {
        $request->validate([
            'mobile' => 'required|string',
            'otp' => 'nullable|string',
        ]);

        $mobile = $request->input('mobile');
        $user = User::where('phone', $mobile)->orWhere('email', $mobile)->first();

        if (! $user) {
            // Auto register if user does not exist
            $user = User::create([
                'name' => $request->input('name', 'User '.substr($mobile, -4)),
                'phone' => $mobile,
                'email' => $request->input('email', $mobile.'@designera.shop'),
                'password' => Hash::make(Str::random(16)),
                'status' => 1,
            ]);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'OTP verified successfully',
            'token_type' => 'Bearer',
            'token' => $token,
            'user' => $user->load('plan'),
        ]);
    });

    /**
     * Authenticated User Routes (Requires Authorization: Bearer <token>)
     */
    Route::middleware('auth:sanctum')->group(function () {

        // Get Authenticated User Profile
        Route::get('/auth/me', function (Request $request) {
            $user = $request->user();
            $user->markPlanExpiredIfDue();

            return response()->json([
                'status' => 'success',
                'user' => $user->load(['plan', 'activePlanHistory']),
            ]);
        });

        Route::post('/auth/device-token', function (Request $request) {
            $validated = $request->validate([
                'fcm_token' => 'required|string|max:4096',
                'platform' => 'nullable|string|in:android,ios,web',
            ]);

            UserDeviceToken::query()->updateOrCreate(
                ['token_hash' => hash('sha256', $validated['fcm_token'])],
                [
                    'user_id' => $request->user()->getKey(),
                    'fcm_token' => $validated['fcm_token'],
                    'platform' => $validated['platform'] ?? null,
                    'last_seen_at' => now(),
                ],
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Device notification token registered.',
            ]);
        })->middleware('throttle:30,1');

        Route::delete('/auth/device-token', function (Request $request) {
            $validated = $request->validate([
                'fcm_token' => 'required|string|max:4096',
            ]);

            UserDeviceToken::query()
                ->where('user_id', $request->user()->getKey())
                ->where('token_hash', hash('sha256', $validated['fcm_token']))
                ->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Device notification token removed.',
            ]);
        })->middleware('throttle:30,1');

        // Update Profile
        Route::post('/auth/update-profile', function (Request $request) {
            $user = $request->user();

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => [
                    'sometimes',
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($user->getKey()),
                ],
                'mobile' => 'sometimes|nullable|string|max:20',
                'phone' => 'sometimes|nullable|string|max:20',
                'state' => 'sometimes|nullable|string',
                'city' => 'sometimes|nullable|string',
                'party' => 'sometimes|nullable|string',
                'designation_1' => 'sometimes|nullable|string',
                'designation_2' => 'sometimes|nullable|string',
                'whatsapp' => 'sometimes|nullable|string',
                'facebook' => 'sometimes|nullable|string',
                'twitter' => 'sometimes|nullable|string',
                'instagram' => 'sometimes|nullable|string',
                'language' => 'sometimes|nullable|string',
                'profile_photo' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
                'business_logo' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            ]);

            if (isset($validated['mobile'])) {
                $validated['phone'] = $validated['mobile'];
            }

            if ($request->hasFile('profile_photo')) {
                $validated['profile_pic'] = $request->file('profile_photo')->store('users/profile', 'public');
                unset($validated['profile_photo']);
            }

            if ($request->hasFile('business_logo')) {
                $validated['business_logo'] = $request->file('business_logo')->store('users/business-logos', 'public');
            }

            $user->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'user' => $user->fresh(['plan', 'activePlanHistory']),
            ]);
        });

        // Current User Plan History (Token-based)
        Route::get('/auth/plan-history', function (Request $request) {
            $user = $request->user();
            $user->markPlanExpiredIfDue();
            $histories = UserPlanHistory::where('user_id', $user->id)
                ->orderBy('id', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'current_plan_id' => $user->plan_id,
                ],
                'count' => $histories->count(),
                'data' => $histories,
            ]);
        });

        // Current User Subscribe Plan (Token-based)
        Route::post('/auth/subscribe-plan', function (Request $request) {
            $request->validate([
                'plan_id' => 'required|integer|exists:plans,id',
                'payment_method' => 'nullable|string',
                'transaction_id' => 'nullable|string',
                'notes' => 'nullable|string',
            ]);

            $user = $request->user();
            $plan = Plan::findOrFail($request->input('plan_id'));
            $durationDays = (int) ($plan->duration_days ?: 30);
            $startDate = now();
            $endDate = $startDate->copy()->addDays($durationDays);
            $walletColumn = Schema::hasColumn('users', 'balance')
                ? 'balance'
                : (Schema::hasColumn('users', 'wallet_balance') ? 'wallet_balance' : null);

            if ($walletColumn === null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Wallet balance is unavailable for this account.',
                ], 500);
            }

            $subscription = DB::transaction(function () use ($durationDays, $endDate, $plan, $request, $startDate, $user, $walletColumn) {
                $lockedUser = User::query()->whereKey($user->id)->lockForUpdate()->firstOrFail();
                $balance = (float) DB::table('users')->where('id', $lockedUser->id)->value($walletColumn);
                $price = (float) $plan->price;

                if ($balance < $price) {
                    return ['insufficient_balance' => true, 'balance' => $balance, 'required_amount' => $price];
                }

                if ($price > 0) {
                    DB::table('users')->where('id', $lockedUser->id)->decrement($walletColumn, $price);
                }

                UserPlanHistory::where('user_id', $lockedUser->id)
                    ->where('status', 'active')
                    ->update(['status' => 'upgraded']);

                $history = UserPlanHistory::create([
                    'user_id' => $lockedUser->id,
                    'plan_id' => $plan->id,
                    'plan_name' => $plan->name,
                    'price' => $price,
                    'duration_days' => $durationDays,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => 'active',
                    'daily_limit_design' => (int) $plan->daily_limit_design,
                    'daily_limit_video' => (int) $plan->daily_limit_video,
                    'payment_method' => 'wallet',
                    'transaction_id' => $request->input('transaction_id'),
                    'notes' => $request->input('notes', 'Subscribed via App Token Auth'),
                ]);

                $lockedUser->forceFill([
                    'plan_id' => (string) $plan->id,
                    'start_date' => $startDate->toDateString(),
                    'expiry_date' => $endDate->toDateString(),
                    'plan_expired' => false,
                ])->save();
                DB::table('users')->where('id', $lockedUser->id)->update([
                    'design_daily_download_limit' => (int) $plan->daily_limit_design,
                    'video_daily_download_limit' => (int) $plan->daily_limit_video,
                ]);

                $newBalance = (float) DB::table('users')->where('id', $lockedUser->id)->value($walletColumn);

                $freshUser = $lockedUser->fresh('plan');
                $userResponse = $freshUser->toArray();
                $userResponse['start_date'] = $startDate->format('d M Y h:i a');
                $userResponse['expiry_date'] = $endDate->format('d M Y h:i a');

                return ['history' => $history, 'user' => $userResponse, 'balance' => $newBalance];
            });

            if (isset($subscription['insufficient_balance'])) {
                return response()->json([
                    'status' => 'insufficient_balance',
                    'message' => 'Insufficient wallet balance. Add money to your wallet to subscribe.',
                    'balance' => $subscription['balance'],
                    'required_amount' => $subscription['required_amount'],
                ], 402);
            }

            return response()->json([
                'status' => 'success',
                'message' => "Plan '{$plan->name}' activated successfully",
                'plan_history' => $subscription['history'],
                'user' => $subscription['user'],
                'balance' => $subscription['balance'],
            ], 201);
        });

        // User Logout (Revoke Token)
        Route::post('/auth/logout', function (Request $request) {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Logged out successfully, token revoked',
            ]);
        });
    });

    // ==========================================
    // 3b. Users Admin API
    // ==========================================
    Route::get('/users', function (Request $request) {
        $query = User::query();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->input('plan_id'));
        }
        if ($request->filled('state')) {
            $query->where('state', $request->input('state'));
        }
        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%")
                    ->orWhere('phone', 'like', "%{$s}%");
            });
        }

        $limit = min((int) $request->input('limit', 20), 100);
        $users = $query->latest()->paginate($limit);

        return response()->json([
            'status' => 'success',
            'total' => $users->total(),
            'current_page' => $users->currentPage(),
            'data' => $users->items(),
        ]);
    });

    Route::get('/users/{id}', function ($id) {
        $user = User::find($id);
        if (! $user) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $user]);
    });

    Route::post('/users', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'party' => 'nullable|string',
        ]);

        if (isset($validated['mobile'])) {
            $validated['phone'] = $validated['mobile'];
        }

        $validated['password'] = Hash::make($request->input('password', 'secret123'));
        $user = User::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    });

    // ==========================================
    // 4. Plans & User Plan History API
    // ==========================================
    Route::get('/plans', function () {
        $plans = Plan::query()
            ->where('status', 1)
            ->where('is_display', 1)
            ->get()
            ->each(function (Plan $plan): void {
                if (filled($plan->image)) {
                    $plan->image = FileManager::publicThumbnailUrl($plan->image);
                }
            });

        return response()->json([
            'status' => 'success',
            'count' => $plans->count(),
            'data' => $plans,
        ]);
    });

    Route::get('/plans/{id}', function ($id) {
        $plan = Plan::find($id);
        if (! $plan) {
            return response()->json(['status' => 'error', 'message' => 'Plan not found'], 404);
        }

        if (filled($plan->image)) {
            $plan->image = FileManager::publicThumbnailUrl($plan->image);
        }

        return response()->json(['status' => 'success', 'data' => $plan]);
    });

    /**
     * Subscribe / Assign Plan to User (saves history in dedicated user_plan_histories table)
     */
    Route::post('/user-plans/subscribe', function (Request $request) {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'plan_id' => 'required|integer|exists:plans,id',
            'payment_method' => 'nullable|string',
            'transaction_id' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $user = User::findOrFail($validated['user_id']);
        $plan = Plan::findOrFail($validated['plan_id']);

        $durationDays = (int) ($plan->duration_days ?: 30);
        $startDate = now();
        $endDate = now()->addDays($durationDays);

        // Mark previous active plans as upgraded
        UserPlanHistory::where('user_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'upgraded']);

        // Insert new record into dedicated user_plan_histories table
        $history = UserPlanHistory::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'plan_name' => $plan->name,
            'price' => $plan->price ?? 0.00,
            'duration_days' => $durationDays,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
            'daily_limit_design' => (int) ($plan->daily_limit_design ?? 0),
            'daily_limit_video' => (int) ($plan->daily_limit_video ?? 0),
            'payment_method' => $validated['payment_method'] ?? 'app',
            'transaction_id' => $validated['transaction_id'] ?? null,
            'notes' => $validated['notes'] ?? 'Subscribed via API',
        ]);

        // Update user record
        $user->plan_id = $plan->id;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => "Plan '{$plan->name}' assigned successfully to user '{$user->name}'",
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'plan_id' => $user->plan_id,
                ],
                'plan_history' => $history,
            ],
        ], 201);
    });

    /**
     * Get Plan History for a specific user
     */
    Route::get('/users/{id}/plan-history', function ($id) {
        $user = User::find($id);
        if (! $user) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }

        $histories = UserPlanHistory::where('user_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'current_plan_id' => $user->plan_id,
            ],
            'count' => $histories->count(),
            'data' => $histories,
        ]);
    });

    /**
     * Query all user plan histories (with filters)
     */
    Route::get('/user-plan-histories', function (Request $request) {
        $query = UserPlanHistory::with(['user:id,name,email,phone', 'plan:id,name,price']);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }
        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->input('plan_id'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->input('payment_method'));
        }

        $limit = min((int) $request->input('limit', 20), 100);
        $histories = $query->latest('id')->paginate($limit);

        return response()->json([
            'status' => 'success',
            'total' => $histories->total(),
            'current_page' => $histories->currentPage(),
            'per_page' => $histories->perPage(),
            'data' => $histories->items(),
        ]);
    });

    // ==========================================
    // 5. Coupons API
    // ==========================================
    Route::get('/coupons', function (Request $request) {
        $query = Coupon::where('status', 1);
        $coupons = $query->latest()->get();

        return response()->json([
            'status' => 'success',
            'count' => $coupons->count(),
            'data' => $coupons,
        ]);
    });

    Route::post('/coupons/validate', function (Request $request) {
        $request->validate(['code' => 'required|string']);
        $coupon = Coupon::where('code', $request->input('code'))
            ->where('status', 1)
            ->first();

        if (! $coupon) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or inactive coupon code',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Coupon code is valid',
            'data' => $coupon,
        ]);
    });

    // ==========================================
    // 6. Categories (Parent, Category, Sub)
    // ==========================================
    Route::get('/parent-categories', function (Request $request) {
        $query = ParentCategory::query();
        if (Schema::hasColumn('parent_category', 'status')) {
            if ($request->has('status')) {
                $query->where('status', $request->input('status'));
            } else {
                $query->where('status', 1);
            }
        }

        if ($request->boolean('with_categories')) {
            $query->with(['categories' => function ($q) {
                if (Schema::hasColumn('category', 'status')) {
                    $q->where('status', 1);
                }
            }]);
        }

        if (Schema::hasColumn('parent_category', 'sequence')) {
            $parents = $query->orderByRaw('CASE WHEN sequence > 0 THEN sequence ELSE 999999 END ASC')
                ->orderBy('id', 'asc')
                ->get();
        } else {
            $parents = $query->orderBy('id', 'asc')->get();
        }

        $parents->each(function (ParentCategory $parent): void {
            if (filled($parent->image)) {
                $parent->image = FileManager::publicThumbnailUrl($parent->image);
            }
        });

        return response()->json([
            'status' => 'success',
            'whatsapp_number' => Setting::get('whatsapp_number', '919158592601'),
            'count' => $parents->count(),
            'data' => $parents,
        ]);
    });

    Route::get('/parent-categories/{id}', function ($id) {
        $parent = ParentCategory::with(['categories.subCategories'])->find($id);
        if (! $parent) {
            return response()->json(['status' => 'error', 'message' => 'Parent category not found'], 404);
        }

        if (filled($parent->image)) {
            $parent->image = FileManager::publicThumbnailUrl($parent->image);
        }

        return response()->json(['status' => 'success', 'data' => $parent]);
    });

    /**
     * Parent Category Screen API:
     * When user clicks on a Parent Category -> returns Parent Category details,
     * child Categories list (for tabs/filters), and the Design Masking listings.
     */
    Route::get('/parent-categories/{id}/design-maskings', function (Request $request, $id) {
        $parent = ParentCategory::find($id);
        if (! $parent) {
            return response()->json([
                'status' => 'error',
                'message' => 'Parent category not found',
            ], 404);
        }

        // 1. Get all active categories under this parent category
        $categories = Category::where('parent_category_id', $id)
            ->where('status', 1)
            ->with(['subCategories' => function ($q) {
                $q->where('status', 1);
            }])
            ->get();

        $categoryIds = $categories->pluck('id')->toArray();

        // 2. Query Design Maskings under this parent category or its child categories
        $maskingsQuery = DesignMasking::where('status', 1)
            ->where(function ($q) use ($id, $categoryIds) {
                $q->where('parent_category_id', $id);
                if (! empty($categoryIds)) {
                    $q->orWhereIn('category_id', $categoryIds);
                }
            });

        // Filter by specific category tab if selected
        if ($request->filled('category_id')) {
            $maskingsQuery->where('category_id', $request->input('category_id'));
        }

        // Filter by sub category if selected
        if ($request->filled('sub_category_id')) {
            $maskingsQuery->where('sub_category_id', $request->input('sub_category_id'));
        }

        // Additional filters (language, special_day, state, party, plan)
        if ($request->filled('special_day')) {
            $maskingsQuery->where('special_day', $request->input('special_day'));
        }
        if ($request->filled('language')) {
            $maskingsQuery->where('language', $request->input('language'));
        }
        if ($request->filled('state')) {
            $maskingsQuery->where('state', $request->input('state'));
        }
        if ($request->filled('party')) {
            $maskingsQuery->where('party', $request->input('party'));
        }
        if ($request->filled('plan')) {
            $maskingsQuery->where('plan', $request->input('plan'));
        }
        if ($request->filled('show_in_slider')) {
            $maskingsQuery->where('show_in_slider', $request->input('show_in_slider'));
        }
        if ($request->has('front_img')) {
            $maskingsQuery->where('front_img', $request->boolean('front_img'));
        }
        if ($request->has('back')) {
            $maskingsQuery->where('back', $request->boolean('back'));
        }

        $limit = min((int) $request->input('limit', 20), 100);
        $maskings = $maskingsQuery->latest()->paginate($limit);
        $maskingItems = collect($maskings->items())->map(function (DesignMasking $masking) {
            $item = $masking->toArray();
            if (filled($masking->design)) {
                $item['design'] = FileManager::publicThumbnailUrl($masking->design);
                $item['design_url'] = $item['design'];
            }
            // Keep the database field name and expose the app-facing alias as well.
            $item['copyrightwatermark'] = $masking->copyright_position;
            $item['design_type'] = 'design_masking';

            return $item;
        });

        return response()->json([
            'status' => 'success',
            'parent_category' => [
                'id' => $parent->id,
                'title' => $parent->title,
                'status' => $parent->status,
            ],
            'categories' => $categories,
            'maskings' => [
                'total' => $maskings->total(),
                'current_page' => $maskings->currentPage(),
                'per_page' => $maskings->perPage(),
                'last_page' => $maskings->lastPage(),
                'data' => $maskingItems,
            ],
        ]);
    });

    Route::get('/categories', function (Request $request) {
        $query = Category::where('status', 1);
        if ($request->filled('parent_category_id')) {
            $query->where('parent_category_id', $request->input('parent_category_id'));
        }
        $categories = $query->get();

        return response()->json([
            'status' => 'success',
            'count' => $categories->count(),
            'data' => $categories,
        ]);
    });

    Route::get('/categories/{id}', function ($id) {
        $cat = Category::with('subCategories')->find($id);
        if (! $cat) {
            return response()->json(['status' => 'error', 'message' => 'Category not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $cat]);
    });

    Route::get('/sub-categories', function (Request $request) {
        $query = SubCategory::where('status', 1);
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
        if ($request->filled('parent_category_id')) {
            $query->where('parent_category_id', $request->input('parent_category_id'));
        }
        $subCategories = $query->get();

        return response()->json([
            'status' => 'success',
            'count' => $subCategories->count(),
            'data' => $subCategories,
        ]);
    });

    // ==========================================
    // 7. Special Days API
    // ==========================================
    Route::get('/special-days', function (Request $request) {
        $baseQuery = SpecialDay::where('status', 1)
            ->whereNotNull('name')
            ->where('name', '!=', '');

        $query = clone $baseQuery;

        if ($request->filled('day')) {
            $dayParam = strtolower($request->input('day'));
            $target = $dayParam === 'tomorrow' ? now()->addDay() : now();
            $query->where(function ($q) use ($target) {
                $q->whereDate('date', $target->toDateString())
                    ->orWhereDate('s_date', $target->toDateString())
                    ->orWhere(function ($m) use ($target) {
                        $m->whereMonth('date', $target->month)
                            ->whereDay('date', $target->day);
                    });
            });
        } elseif ($request->filled('date')) {
            $target = Carbon::parse($request->input('date'));
            $query->where(function ($q) use ($target) {
                $q->whereDate('date', $target->toDateString())
                    ->orWhereDate('s_date', $target->toDateString())
                    ->orWhere(function ($m) use ($target) {
                        $m->whereMonth('date', $target->month)
                            ->whereDay('date', $target->day);
                    });
            });
        }

        // If filtered query has no items, fallback to all active special days
        $count = (clone $query)->count();
        if ($count === 0 && ($request->filled('day') || $request->filled('date'))) {
            $query = clone $baseQuery;
        }

        $limit = min((int) $request->input('limit', 50), 200);
        $days = $query->orderByRaw('CASE WHEN sequence > 0 THEN sequence ELSE 999999 END ASC')
            ->orderBy('is_priority', 'desc')
            ->latest('date')
            ->latest('id')
            ->paginate($limit);

        return response()->json([
            'status' => 'success',
            'count' => $days->total(),
            'total' => $days->total(),
            'data' => collect($days->items())->map(function (SpecialDay $day): SpecialDay {
                if (filled($day->image)) {
                    $day->image = FileManager::publicThumbnailUrl($day->image);
                }

                return $day;
            }),
        ]);
    });

    // ==========================================
    // 8. Parties API
    // ==========================================
    $formatPartyImages = static function (Party $party): Party {
        $imageFields = ['image', 'party_image', 'symbol', 'top_image', 'bottom_image', 'custom_image'];
        $formatImageValue = null;
        $formatImageValue = static function (mixed $value) use (&$formatImageValue): mixed {
            if (is_array($value)) {
                foreach ($value as $key => $nestedValue) {
                    $value[$key] = $formatImageValue($nestedValue);
                }

                return $value;
            }

            if (is_string($value) && filled($value)) {
                $imagePath = parse_url($value, PHP_URL_PATH) ?: $value;
                $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
                if (! in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif', 'svg'], true)) {
                    return $value;
                }

                return FileManager::publicThumbnailUrl($value);
            }

            return $value;
        };

        foreach ($imageFields as $imageField) {
            if (filled($party->{$imageField})) {
                $party->{$imageField} = $formatImageValue($party->{$imageField});
            }
        }

        return $party;
    };

    Route::get('/parties', function (Request $request) use ($formatPartyImages) {
        $query = Party::query();
        if ($request->filled('state')) {
            $stateId = (string) $request->input('state');
            $partyTable = (new Party)->getTable();

            if (Schema::hasColumn($partyTable, 'state')) {
                $query->where('state', $stateId);
            } elseif (Schema::hasColumn($partyTable, 'states')) {
                $query->where(function ($stateQuery) use ($stateId) {
                    $stateQuery->whereJsonContains('states', $stateId);

                    if (ctype_digit($stateId)) {
                        $stateQuery->orWhereJsonContains('states', (int) $stateId);
                    }
                });
            }
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        $parties = $query->get()->map($formatPartyImages);

        return response()->json([
            'status' => 'success',
            'count' => $parties->count(),
            'data' => $parties,
        ]);
    });

    Route::get('/parties/{id}', function ($id) use ($formatPartyImages) {
        $party = Party::find($id);
        if (! $party) {
            return response()->json(['status' => 'error', 'message' => 'Party not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $formatPartyImages($party)]);
    });

    // ==========================================
    // 9. Designs API (Includes Today & Tomorrow Filter)
    // ==========================================

    /**
     * Dedicated Today & Tomorrow Feed API:
     * Returns both Today and Tomorrow designs grouped with date metadata.
     */
    Route::get('/designs/today-tomorrow', function (Request $request) {
        $today = Carbon::today()->toDateString();
        $tomorrow = Carbon::tomorrow()->toDateString();

        $buildDateQuery = function ($targetDate) use ($request) {
            $specialDayIds = SpecialDay::where(function ($sq) use ($targetDate) {
                $sq->whereDate('date', $targetDate)
                    ->orWhereDate('s_date', $targetDate);
            })->pluck('id')->toArray();

            $query = Design::where('status', 1)
                ->where(function ($q) use ($targetDate, $specialDayIds) {
                    $q->whereDate('date', $targetDate);
                    if (! empty($specialDayIds)) {
                        $q->orWhereIn('special_day', $specialDayIds);
                    }
                    $q->orWhere(function ($sub) use ($targetDate) {
                        $sub->whereNotNull('date')
                            ->whereNotNull('up_to_days')
                            ->whereDate('date', '<=', $targetDate)
                            ->whereRaw('DATE_ADD(date, INTERVAL up_to_days DAY) >= ?', [$targetDate]);
                    });
                });

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->input('category_id'));
            }
            if ($request->filled('parent_category_id')) {
                $query->where('parent_category_id', $request->input('parent_category_id'));
            }
            if ($request->filled('sub_category_id')) {
                $query->where('sub_category_id', $request->input('sub_category_id'));
            }
            if ($request->filled('language')) {
                $query->where('language', $request->input('language'));
            }
            if ($request->filled('state')) {
                $query->where('state', $request->input('state'));
            }
            if ($request->filled('party')) {
                $query->where('party', $request->input('party'));
            }
            if ($request->filled('special_day')) {
                $query->where('special_day', $request->input('special_day'));
            }

            if ($request->boolean('with_relations')) {
                $query->with(['category', 'parentCategory', 'subCategory']);
            }

            return $query->latest()->get();
        };

        $todayDesigns = $buildDateQuery($today)->map(function (Design $item) {
            $item->day_type = 'today';
            if (filled($item->design)) {
                $item->design = FileManager::publicThumbnailUrl($item->design);
            }

            return $item;
        });

        $tomorrowDesigns = $buildDateQuery($tomorrow)->map(function (Design $item) {
            $item->day_type = 'tomorrow';
            if (filled($item->design)) {
                $item->design = FileManager::publicThumbnailUrl($item->design);
            }

            return $item;
        });

        return response()->json([
            'status' => 'success',
            'dates' => [
                'today' => $today,
                'today_formatted' => Carbon::today()->format('D, M d, Y'),
                'tomorrow' => $tomorrow,
                'tomorrow_formatted' => Carbon::tomorrow()->format('D, M d, Y'),
            ],
            'today' => [
                'count' => $todayDesigns->count(),
                'data' => $todayDesigns,
            ],
            'tomorrow' => [
                'count' => $tomorrowDesigns->count(),
                'data' => $tomorrowDesigns,
            ],
        ]);
    });

    /**
     * General Designs API (supports ?day=today, ?day=tomorrow, or ?date=YYYY-MM-DD)
     */
    Route::get('/designs', function (Request $request) {
        $query = Design::where('status', 1);

        // Date / Day Filters (Today & Tomorrow)
        if ($request->filled('day')) {
            $dayParam = strtolower($request->input('day'));
            $targetDate = $dayParam === 'tomorrow'
                ? Carbon::tomorrow()->toDateString()
                : Carbon::today()->toDateString();

            $specialDayIds = SpecialDay::where(function ($sq) use ($targetDate) {
                $sq->whereDate('date', $targetDate)
                    ->orWhereDate('s_date', $targetDate);
            })->pluck('id')->toArray();

            $query->where(function ($q) use ($targetDate, $specialDayIds) {
                $q->whereDate('date', $targetDate);
                if (! empty($specialDayIds)) {
                    $q->orWhereIn('special_day', $specialDayIds);
                }
                $q->orWhere(function ($sub) use ($targetDate) {
                    $sub->whereNotNull('date')
                        ->whereNotNull('up_to_days')
                        ->whereDate('date', '<=', $targetDate)
                        ->whereRaw('DATE_ADD(date, INTERVAL up_to_days DAY) >= ?', [$targetDate]);
                });
            });
        } elseif ($request->filled('date')) {
            $targetDate = $request->input('date');
            $specialDayIds = SpecialDay::where(function ($sq) use ($targetDate) {
                $sq->whereDate('date', $targetDate)
                    ->orWhereDate('s_date', $targetDate);
            })->pluck('id')->toArray();

            $query->where(function ($q) use ($targetDate, $specialDayIds) {
                $q->whereDate('date', $targetDate);
                if (! empty($specialDayIds)) {
                    $q->orWhereIn('special_day', $specialDayIds);
                }
                $q->orWhere(function ($sub) use ($targetDate) {
                    $sub->whereNotNull('date')
                        ->whereNotNull('up_to_days')
                        ->whereDate('date', '<=', $targetDate)
                        ->whereRaw('DATE_ADD(date, INTERVAL up_to_days DAY) >= ?', [$targetDate]);
                });
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
        if ($request->filled('parent_category_id')) {
            $query->where('parent_category_id', $request->input('parent_category_id'));
        }
        if ($request->filled('sub_category_id')) {
            $query->where('sub_category_id', $request->input('sub_category_id'));
        }
        if ($request->filled('special_day')) {
            $query->where('special_day', $request->input('special_day'));
        }
        if ($request->filled('language')) {
            $query->where('language', $request->input('language'));
        }
        if ($request->filled('state')) {
            $query->where('state', $request->input('state'));
        }
        if ($request->filled('party')) {
            $query->where('party', $request->input('party'));
        }
        if ($request->filled('plan')) {
            $query->where('plan', $request->input('plan'));
        }
        if ($request->filled('show_in_slider')) {
            $query->where('show_in_slider', $request->input('show_in_slider'));
        }

        if ($request->boolean('with_relations')) {
            $query->with(['category', 'parentCategory', 'subCategory']);
        }

        $limit = min((int) $request->input('limit', 20), 100);
        $designs = $query->latest()->paginate($limit);

        // Add day_type tag for each design dynamically based on date
        $todayStr = Carbon::today()->toDateString();
        $tomorrowStr = Carbon::tomorrow()->toDateString();

        $transformedItems = collect($designs->items())->map(function ($item) use ($todayStr, $tomorrowStr) {
            $itemDate = $item->date ? Carbon::parse($item->date)->toDateString() : null;
            if ($itemDate === $todayStr) {
                $item->day_type = 'today';
            } elseif ($itemDate === $tomorrowStr) {
                $item->day_type = 'tomorrow';
            } else {
                $item->day_type = 'other';
            }
            if (! empty($item->special_day)) {
                if (is_numeric($item->special_day)) {
                    $sd = SpecialDay::find($item->special_day);
                    $item->special_day_name = $sd ? ($sd->name ?? $sd->eng_name) : (string) $item->special_day;
                } else {
                    $item->special_day_name = (string) $item->special_day;
                }
            } else {
                $item->special_day_name = '';
            }

            if (filled($item->design)) {
                $item->design = FileManager::publicThumbnailUrl($item->design);
            }

            return $item;
        });

        return response()->json([
            'status' => 'success',
            'filter_applied' => $request->input('day', $request->input('date', 'all')),
            'current_date' => $todayStr,
            'tomorrow_date' => $tomorrowStr,
            'total' => $designs->total(),
            'current_page' => $designs->currentPage(),
            'per_page' => $designs->perPage(),
            'last_page' => $designs->lastPage(),
            'data' => $transformedItems,
        ]);
    });

    Route::get('/designs/{id}', function ($id) {
        $design = Design::with(['category', 'parentCategory', 'subCategory'])->find($id);
        if (! $design) {
            return response()->json(['status' => 'error', 'message' => 'Design not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $design]);
    });

    /**
     * Track Design View (Unique per user / device)
     * POST /api/v1/designs/{id}/view
     * POST /api/v1/designs/view
     */
    $handleDesignView = function (Request $request, $id = null) {
        $designId = $id ?: $request->input('design_id');
        $designType = strtolower((string) $request->input('design_type', 'design'));
        $designType = in_array($designType, ['design_masking', 'masking'], true) ? 'design_masking' : 'design';
        $design = $designType === 'design_masking' ? DesignMasking::find($designId) : Design::find($designId);
        if (! $design) {
            return response()->json(['status' => 'error', 'message' => 'Design not found'], 404);
        }

        // Identify user
        $user = $request->user('sanctum') ?: ($request->filled('user_id') ? User::find($request->input('user_id')) : null);
        $userId = $user?->id;
        $deviceId = $request->input('device_id', $request->header('X-Device-Id'));
        $ip = $request->ip();

        $alreadyViewed = false;

        if ($userId) {
            $alreadyViewed = DesignView::where('design_id', $design->id)
                ->where('design_type', $designType)
                ->where('user_id', $userId)
                ->exists();
        } elseif (! empty($deviceId)) {
            $alreadyViewed = DesignView::where('design_id', $design->id)
                ->where('design_type', $designType)
                ->where('device_id', $deviceId)
                ->exists();
        }

        $newView = false;
        if (! $alreadyViewed) {
            try {
                DesignView::create([
                    'design_type' => $designType,
                    'design_id' => $design->id,
                    'user_id' => $userId,
                    'device_id' => $deviceId,
                    'ip_address' => $ip,
                ]);
                $newView = true;
            } catch (Throwable $e) {
                // Ignore race condition on duplicate
            }

            if ($newView) {
                $design->increment('views');
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => $newView ? 'View recorded successfully' : 'View already recorded for this user or device',
            'is_new_view' => $newView,
            'design_type' => $designType,
            'design_id' => $design->id,
            'views' => (int) $design->fresh()->views,
        ]);
    };

    Route::post('/designs/{id}/view', $handleDesignView);
    Route::post('/designs/view', $handleDesignView);

    /**
     * Download Design with Daily Quota Limit Check & Wallet Deduction
     * POST /api/v1/designs/{id}/download
     * POST /api/v1/designs/download
     */
    $handleDesignDownload = function (Request $request, $id = null) {
        $designId = $id ?: $request->input('design_id');
        $requestedDesignType = strtolower((string) $request->input('design_type', 'design'));
        $isVideo = $requestedDesignType === 'video'
            || strtolower((string) $request->input('view_type', '')) === 'video';
        $designType = $isVideo
            ? 'video'
            : (in_array($requestedDesignType, ['design_masking', 'masking'], true) ? 'design_masking' : 'design');
        $design = match ($designType) {
            'video' => Video::find($designId),
            'design_masking' => DesignMasking::find($designId),
            default => Design::find($designId),
        };
        if (! $design) {
            return response()->json([
                'status' => 'error',
                'message' => $isVideo ? 'Video not found' : 'Design not found',
            ], 404);
        }

        // Identify user
        $user = $request->user('sanctum');
        if (! $user && $request->bearerToken()) {
            try {
                $pat = PersonalAccessToken::findToken($request->bearerToken());
                if ($pat) {
                    $user = $pat->tokenable;
                }
            } catch (Throwable $e) {
            }
        }
        if (! $user && $request->filled('user_id')) {
            $user = User::find($request->input('user_id'));
        }
        // Fallback to first user for guest downloads so flow is never blocked
        if (! $user) {
            $user = User::first();
        }

        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User authentication or user_id is required to download design.',
            ], 401);
        }

        $today = Carbon::today()->toDateString();
        $viewType = strtolower((string) $request->input('view_type', $design->view_type ?? ''));
        $downloadHistoryType = $viewType === 'video' ? 'video' : 'design';
        $useWallet = $request->boolean('use_wallet') || (int) $request->input('use_wallet') === 1;

        // 1. Check user daily limit from plan or user record
        $dailyLimit = $downloadHistoryType === 'video' ? 10 : 20;
        $activePlan = $user->activePlanHistory;
        if ($activePlan && $activePlan->end_date && $activePlan->end_date->isPast()) {
            $activePlan = null;
        }
        $activePlan ??= $user->plan;
        $planLimit = $downloadHistoryType === 'video'
            ? ($activePlan->daily_limit_video ?? 0)
            : ($activePlan->daily_limit_design ?? 0);
        $userLimit = $downloadHistoryType === 'video'
            ? ($user->daily_download_limit_video ?? 0)
            : ($user->daily_download_limit_design ?? 0);
        if ((int) $planLimit > 0) {
            $dailyLimit = (int) $planLimit;
        } elseif ((int) $userLimit > 0) {
            $dailyLimit = (int) $userLimit;
        }

        // 2. Check today's download count from photo_history
        $downloadsToday = PhotoHistory::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->where('type', $downloadHistoryType)
            ->count();

        $limitExhausted = ($dailyLimit > 0 && $downloadsToday >= $dailyLimit);
        $designPrice = (float) ($design->price > 0 ? $design->price : 5.00);
        $walletColumn = Schema::hasColumn('users', 'balance')
            ? 'balance'
            : (Schema::hasColumn('users', 'wallet_balance') ? 'wallet_balance' : null);
        $userBalance = $walletColumn === null
            ? 0.00
            : (float) DB::table('users')->where('id', $user->id)->value($walletColumn);

        // Case A: Limit reached, but user has not agreed to use wallet
        if ($limitExhausted && ! $useWallet) {
            return response()->json([
                'status' => 'limit_reached',
                'limit_exhausted' => true,
                'message' => 'Daily download limit reached. Do you want to download using wallet balance?',
                'daily_limit' => $dailyLimit,
                'downloads_today' => $downloadsToday,
                'design_price' => $designPrice,
                'wallet_balance' => $userBalance,
                'can_use_wallet' => ($userBalance >= $designPrice),
                'wallet_status' => false,
            ], 200);
        }

        $walletDeducted = false;

        // Case B: Limit reached and user agrees to pay from wallet
        if ($limitExhausted && $useWallet) {
            if ($userBalance < $designPrice) {
                return response()->json([
                    'status' => 'insufficient_balance',
                    'limit_exhausted' => true,
                    'message' => "Insufficient wallet balance (₹{$userBalance}). Required amount: ₹{$designPrice}. Please recharge.",
                    'wallet_balance' => $userBalance,
                    'required_amount' => $designPrice,
                    'wallet_status' => false,
                ], 402);
            }

            if ($walletColumn === null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Wallet balance is unavailable for this account.',
                ], 500);
            }

            $user->decrement($walletColumn, $designPrice);
            $userBalance = (float) DB::table('users')->where('id', $user->id)->value($walletColumn);
            $walletDeducted = true;

            // Log wallet transaction
            try {
                DB::table('transactions')->insert([
                    'user_id' => $user->id,
                    'amount' => -$designPrice,
                    'currency' => 'INR',
                    'type' => 'debit',
                    'payment_method' => 'wallet',
                    'description' => $isVideo
                        ? "Downloaded video #{$design->id}"
                        : "Downloaded design #{$design->id}",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (Throwable $e) {
            }
        }

        // Record in photo_history
        $history = PhotoHistory::create([
            'user_id' => $user->id,
            'photo_id' => $design->id,
            'app_key' => $request->input('app_key', '1'),
            'photo_price' => $walletDeducted ? $designPrice : 0.00,
            'type' => $downloadHistoryType,
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'pincode' => $request->input('pincode'),
        ]);

        if (! $isVideo && Schema::hasColumn($design->getTable(), 'downloads')) {
            $design->increment('downloads');
        }

        $remainingLimit = max(0, $dailyLimit - ($downloadsToday + 1));

        return response()->json([
            'status' => 'success',
            'message' => $isVideo
                ? ($walletDeducted
                    ? "Video download request registered using wallet. ₹{$designPrice} deducted."
                    : 'Video download request registered successfully within free daily limit.')
                : ($walletDeducted
                    ? "Design downloaded successfully using wallet. ₹{$designPrice} deducted."
                    : 'Design downloaded successfully within free daily limit.'),
            'limit_exhausted' => false,
            'wallet_deducted' => $walletDeducted,
            'wallet_status' => true,
            'amount_deducted' => $walletDeducted ? $designPrice : 0.00,
            'balance' => $userBalance,
            'daily_limit' => $dailyLimit,
            'downloads_today' => $downloadsToday + 1,
            'remaining_downloads' => $remainingLimit,
            'design' => [
                'id' => $design->id,
                'design_type' => $designType,
                'downloads' => (int) $design->fresh()->downloads,
                'views' => (int) $design->fresh()->views,
            ],
        ]);
    };

    Route::post('/designs/{id}/download', $handleDesignDownload);
    Route::post('/designs/download', $handleDesignDownload);
    Route::post('/download_design', $handleDesignDownload);
    Route::post('/videos/{id}/download', function (Request $request, $id) use ($handleDesignDownload) {
        $request->merge([
            'design_type' => 'video',
            'view_type' => 'video',
        ]);

        return $handleDesignDownload($request, $id);
    });

    // ==========================================
    // 10. Design Maskings API
    // ==========================================
    Route::get('/design-maskings', function (Request $request) {
        $query = DesignMasking::where('status', 1);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
        if ($request->filled('parent_category_id')) {
            $query->where('parent_category_id', $request->input('parent_category_id'));
        }
        if ($request->filled('sub_category_id')) {
            $query->where('sub_category_id', $request->input('sub_category_id'));
        }
        if ($request->filled('special_day')) {
            $query->where('special_day', $request->input('special_day'));
        }
        if ($request->filled('language')) {
            $query->where('language', $request->input('language'));
        }
        if ($request->filled('state')) {
            $query->where('state', $request->input('state'));
        }
        if ($request->filled('party')) {
            $query->where('party', $request->input('party'));
        }
        if ($request->filled('plan')) {
            $query->where('plan', $request->input('plan'));
        }
        if ($request->filled('show_in_slider')) {
            $query->where('show_in_slider', $request->input('show_in_slider'));
        }
        if ($request->has('front_img')) {
            $query->where('front_img', $request->boolean('front_img'));
        }
        if ($request->has('back')) {
            $query->where('back', $request->boolean('back'));
        }

        if ($request->boolean('with_relations')) {
            $query->with(['category', 'parentCategory', 'subCategory']);
        }

        $limit = min((int) $request->input('limit', 20), 100);
        $maskings = $query->latest()->paginate($limit);

        return response()->json([
            'status' => 'success',
            'total' => $maskings->total(),
            'current_page' => $maskings->currentPage(),
            'per_page' => $maskings->perPage(),
            'last_page' => $maskings->lastPage(),
            'data' => collect($maskings->items())->map(function (DesignMasking $masking) {
                $item = $masking->toArray();
                if (filled($masking->design)) {
                    $item['design'] = FileManager::publicThumbnailUrl($masking->design);
                    $item['design_url'] = $item['design'];
                }
                $item['design_type'] = 'design_masking';

                return $item;
            }),
        ]);
    });

    Route::get('/design-maskings/{id}', function ($id) {
        $masking = DesignMasking::with(['category', 'parentCategory', 'subCategory'])->find($id);
        if (! $masking) {
            return response()->json(['status' => 'error', 'message' => 'Design Masking not found'], 404);
        }

        $item = $masking->toArray();
        $item['design_type'] = 'design_masking';

        return response()->json(['status' => 'success', 'data' => $item]);
    });

    // ==========================================
    // 11. Videos API
    // ==========================================
    Route::get('/videos', function (Request $request) {
        $query = Video::with('specialDay')->where('status', 1);

        if ($request->filled('day') || $request->filled('date')) {
            $dayParam = strtolower($request->input('day', 'today'));
            $targetDate = $request->filled('date')
                ? Carbon::parse($request->input('date'))->toDateString()
                : ($dayParam === 'tomorrow'
                    ? Carbon::tomorrow()->toDateString()
                    : Carbon::today()->toDateString());
            $specialDayIds = SpecialDay::where(function ($specialDays) use ($targetDate) {
                $specialDays->whereDate('date', $targetDate)
                    ->orWhereDate('s_date', $targetDate);
            })->pluck('id')->all();

            $query->where(function ($videos) use ($targetDate, $specialDayIds) {
                $videos->whereDate('date', $targetDate);

                if ($specialDayIds !== []) {
                    $videos->orWhereIn('special_day', $specialDayIds);
                }

                $videos->orWhere(function ($range) use ($targetDate) {
                    $range->whereNotNull('date')
                        ->whereNotNull('up_to_days')
                        ->whereDate('date', '<=', $targetDate)
                        ->whereRaw('DATE_ADD(date, INTERVAL up_to_days DAY) >= ?', [$targetDate]);
                });
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
        if ($request->filled('special_day')) {
            $specialDay = $request->input('special_day');
            $specialDayIds = is_numeric($specialDay)
                ? [(int) $specialDay]
                : SpecialDay::query()
                    ->where('name', $specialDay)
                    ->orWhere('eng_name', $specialDay)
                    ->pluck('id')
                    ->all();

            $query->where(function ($videos) use ($specialDay, $specialDayIds) {
                $videos->where('special_day', $specialDay);

                if ($specialDayIds !== []) {
                    $videos->orWhereIn('special_day', $specialDayIds);
                }
            });
        }
        if ($request->filled('language')) {
            $query->where('language', $request->input('language'));
        }

        $limit = min((int) $request->input('limit', 20), 100);
        $videos = $query->latest()->paginate($limit);
        $today = Carbon::today()->toDateString();
        $tomorrow = Carbon::tomorrow()->toDateString();
        $requestedDay = strtolower((string) $request->input('day', ''));
        $items = collect($videos->items())->map(function (Video $video) use ($requestedDay, $today, $tomorrow) {
            $videoDate = $video->date?->toDateString();
            $publicStorageUrl = static function (?string $path): ?string {
                if (! $path) {
                    return null;
                }

                if (str_starts_with($path, 'http')) {
                    return $path;
                }

                $relativePath = ltrim($path, '/');
                if (str_starts_with($relativePath, 'storage/')) {
                    $relativePath = substr($relativePath, strlen('storage/'));
                }

                return FileManager::publicMediaUrl($relativePath);
            };

            $video->video_url = $publicStorageUrl($video->video);
            $video->thumbnail_url = $video->thumbnail
                ? FileManager::publicThumbnailUrl($video->thumbnail)
                : FileManager::publicThumbnailUrl($video->video);
            $video->thumbnail = $video->thumbnail_url;
            $video->special_day_name = $video->specialDay?->name
                ?? $video->specialDay?->eng_name
                ?? '';
            $video->day_type = in_array($requestedDay, ['today', 'tomorrow'], true)
                ? $requestedDay
                : ($videoDate === $today
                ? 'today'
                : ($videoDate === $tomorrow ? 'tomorrow' : 'other'));

            return $video;
        });

        return response()->json([
            'status' => 'success',
            'total' => $videos->total(),
            'current_page' => $videos->currentPage(),
            'data' => $items,
        ]);
    });

    Route::get('/videos/{id}', function ($id) {
        $video = Video::find($id);
        if (! $video) {
            return response()->json(['status' => 'error', 'message' => 'Video not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $video]);
    });

    // ==========================================
    // 12. Ready Photos & Ready Texts
    // ==========================================
    Route::get('/ready-photos', function (Request $request) {
        $query = ReadyPhoto::where('status', 1);
        if ($request->filled('party')) {
            $query->where('party', $request->input('party'));
        }
        $photos = $query->orderBy('sort_order', 'asc')->get()->map(function ($item) {
            $img = $item->image ?? $item->photo;
            if ($img && ! str_starts_with($img, 'http')) {
                $clean = ltrim($img, '/');
                $item->image = FileManager::publicThumbnailUrl($clean);
            }

            return $item;
        });

        return response()->json([
            'status' => 'success',
            'count' => $photos->count(),
            'data' => $photos,
        ]);
    });

    Route::get('/ready-texts', function (Request $request) {
        $query = ReadyText::where('status', 1);
        if ($request->filled('party')) {
            $query->where('party', $request->input('party'));
        }
        $texts = $query->orderBy('sort_order', 'asc')->get()->map(function ($item) {
            $img = $item->image;
            if ($img && ! str_starts_with($img, 'http')) {
                $clean = ltrim($img, '/');
                $item->image = FileManager::publicThumbnailUrl($clean);
            }

            return $item;
        });

        return response()->json([
            'status' => 'success',
            'count' => $texts->count(),
            'data' => $texts,
        ]);
    });

    // ==========================================
    // 13. Notifications (Regular & Static)
    // ==========================================
    Route::get('/notifications/regular', function () {
        $notifications = RegularNotification::latest()->get();
        if ($notifications->isEmpty()) {
            $notifications = DB::table('notifications')
                ->whereNotNull('title')
                ->where('title', '!=', '')
                ->orderBy('id', 'desc')
                ->limit(50)
                ->get();
        }

        $notifications->each(function ($notification): void {
            if (filled($notification->image ?? null) && ! str_starts_with($notification->image, 'http')) {
                $notification->image = FileManager::publicThumbnailUrl($notification->image);
            }
        });

        return response()->json([
            'status' => 'success',
            'count' => $notifications->count(),
            'data' => $notifications,
        ]);
    });

    Route::get('/notifications/static', function () {
        $notifications = StaticNotification::where('status', 1)->latest()->get();
        $notifications->each(function (StaticNotification $notification): void {
            if (filled($notification->image)) {
                $notification->image = FileManager::publicThumbnailUrl($notification->image);
            }
        });

        return response()->json([
            'status' => 'success',
            'count' => $notifications->count(),
            'data' => $notifications,
        ]);
    });

    // ==========================================
    // 14. Premium Templates API
    // ==========================================
    Route::get('/premium-templates', function (Request $request) {
        $query = UserPremiumTemplate::query();
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        $templates = $query->latest()->get();
        $templates->each(function (UserPremiumTemplate $template): void {
            foreach (['middle_image', 'top_image', 'bottom_image'] as $imageField) {
                if (filled($template->{$imageField})) {
                    $template->{$imageField} = FileManager::publicThumbnailUrl($template->{$imageField});
                }
            }
        });

        return response()->json([
            'status' => 'success',
            'count' => $templates->count(),
            'data' => $templates,
        ]);
    });

    // ==========================================
    // 15. Sliders & Banners API
    // ==========================================
    Route::get('/sliders', function (Request $request) {
        $today = Carbon::today()->toDateString();
        $query = Slider::where('status', 1);

        // Date validity: if start date set, must be <= today; if end date set, must be >= today
        if (! $request->boolean('all_dates')) {
            $query->where(function ($q) use ($today) {
                $q->whereNull('start')->orWhereDate('start', '<=', $today);
            })->where(function ($q) use ($today) {
                $q->whereNull('end')->orWhereDate('end', '>=', $today);
            });
        }

        // Language filter (checks JSON array column)
        if ($request->filled('language')) {
            $lang = strtolower($request->input('language'));
            $query->where(function ($q) use ($lang) {
                $q->whereJsonContains('languages', $lang)
                    ->orWhere('languages', 'like', "%\"{$lang}\"%")
                    ->orWhere('languages', 'like', "%{$lang}%");
            });
        }

        // Redirect To filter
        if ($request->filled('redirect_to')) {
            $query->where('redirect_to', $request->input('redirect_to'));
        }

        $sliders = $query->latest('id')->get()->map(function (Slider $slider): Slider {
            $slider->image = FileManager::publicThumbnailUrl($slider->image);

            return $slider;
        });

        return response()->json([
            'status' => 'success',
            'count' => $sliders->count(),
            'data' => $sliders,
        ]);
    });

    Route::get('/sliders/{id}', function ($id) {
        $slider = Slider::find($id);
        if (! $slider) {
            return response()->json(['status' => 'error', 'message' => 'Slider not found'], 404);
        }

        $slider->image = FileManager::publicThumbnailUrl($slider->image);

        return response()->json(['status' => 'success', 'data' => $slider]);
    });

    // ==========================================
    // 16. Ads API
    // ==========================================
    Route::get('/ads', function (Request $request) {
        $today = Carbon::today()->toDateString();
        $query = Ads::where('status', 1);

        // Date validity: if start date set, must be <= today; if end date set, must be >= today
        if (! $request->boolean('all_dates')) {
            $query->where(function ($q) use ($today) {
                $q->whereNull('start')->orWhereDate('start', '<=', $today);
            })->where(function ($q) use ($today) {
                $q->whereNull('end')->orWhereDate('end', '>=', $today);
            });
        }

        // Language filter (checks JSON array column)
        if ($request->filled('language')) {
            $lang = strtolower($request->input('language'));
            $query->where(function ($q) use ($lang) {
                $q->whereJsonContains('languages', $lang)
                    ->orWhere('languages', 'like', "%\"{$lang}\"%")
                    ->orWhere('languages', 'like', "%{$lang}%");
            });
        }

        // Redirect To filter
        if ($request->filled('redirect_to')) {
            $query->where('redirect_to', $request->input('redirect_to'));
        }

        $ads = $query->latest('id')->get()->map(function (Ads $ad): Ads {
            $ad->image = FileManager::publicThumbnailUrl($ad->image);

            return $ad;
        });

        return response()->json([
            'status' => 'success',
            'count' => $ads->count(),
            'data' => $ads,
        ]);
    });

    Route::get('/ads/{id}', function ($id) {
        $ad = Ads::find($id);
        if (! $ad) {
            return response()->json(['status' => 'error', 'message' => 'Ad not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $ad]);
    });

});
