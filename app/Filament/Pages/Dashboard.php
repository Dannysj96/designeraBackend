<?php

namespace App\Filament\Pages;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Design;
use App\Models\Party;
use App\Models\Plan;
use App\Models\ReadyPhoto;
use App\Models\ReadyText;
use App\Models\SpecialDay;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserPremiumTemplate;
use App\Models\Video;
use Carbon\Carbon;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected string $view = 'filament.pages.dashboard';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static \UnitEnum|string|null $navigationGroup = null;

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?int $navigationSort = 1;

    public function getHeading(): string
    {
        return '';
    }

    public function getSubheading(): ?string
    {
        return null;
    }

    public function getWidgets(): array
    {
        return [];
    }

    public function getViewData(): array
    {
        try {
            // 1. User Metrics
            $totalUsers = User::count();
            $activeUsers = User::where('status', 1)->orWhere('status', 'active')->count();
            $verifiedUsers = User::whereNotNull('email_verified_at')->count();
            $unverifiedUsers = $totalUsers - $verifiedUsers;
            $newUsersThisMonth = User::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
            $newUsersLastMonth = User::whereBetween('created_at', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth(),
            ])->count();
            $userGrowth = $newUsersLastMonth > 0 
                ? round((($newUsersThisMonth - $newUsersLastMonth) / $newUsersLastMonth) * 100, 1) 
                : ($newUsersThisMonth > 0 ? 100 : 0);

            // 2. Design Metrics
            $totalDesigns = Design::count();
            $activeDesigns = Design::where('status', 1)->count();
            $premiumDesigns = Design::where('price', '>', 0)->count();
            $freeDesigns = $totalDesigns - $premiumDesigns;
            $newDesignsThisMonth = Design::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

            // 3. Video Metrics
            $totalVideos = Video::count();
            $activeVideos = Video::where('status', 1)->count();
            $newVideosThisMonth = Video::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

            // 4. Template, Categories & Assets
            $totalPremiumTemplates = UserPremiumTemplate::count();
            $activePremiumTemplates = UserPremiumTemplate::where('status', 1)->count();
            $totalCategories = Category::count();
            $totalSubCategories = SubCategory::count();
            $totalCoupons = Coupon::count();
            $activeCoupons = Coupon::where('status', 1)->count();
            $totalSpecialDays = SpecialDay::count();
            $totalParties = Party::count();
            $totalReadyPhotos = ReadyPhoto::count();
            $totalReadyTexts = ReadyText::count();
            $totalAssets = $totalDesigns + $totalVideos + $totalReadyPhotos + $totalReadyTexts;
        } catch (\Throwable $e) {
            $totalUsers = User::count() ?? 0;
            $activeUsers = $totalUsers;
            $verifiedUsers = $totalUsers;
            $unverifiedUsers = 0;
            $newUsersThisMonth = 0;
            $userGrowth = 0;
            $totalDesigns = 0;
            $activeDesigns = 0;
            $premiumDesigns = 0;
            $freeDesigns = 0;
            $newDesignsThisMonth = 0;
            $totalVideos = 0;
            $activeVideos = 0;
            $newVideosThisMonth = 0;
            $totalPremiumTemplates = 0;
            $activePremiumTemplates = 0;
            $totalCategories = 0;
            $totalSubCategories = 0;
            $totalCoupons = 0;
            $activeCoupons = 0;
            $totalSpecialDays = 0;
            $totalParties = 0;
            $totalReadyPhotos = 0;
            $totalReadyTexts = 0;
            $totalAssets = 0;
        }

        // 5. Dynamic 7-Day Chart Activity
        $chartDays = [];
        $maxDailyActivity = 1;
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateStr = $date->toDateString();
            $usersCount = User::whereDate('created_at', $dateStr)->count();
            $designsCount = Design::whereDate('created_at', $dateStr)->count();
            $videosCount = Video::whereDate('created_at', $dateStr)->count();
            $totalDayActivity = $usersCount + $designsCount + $videosCount;

            if ($totalDayActivity > $maxDailyActivity) {
                $maxDailyActivity = $totalDayActivity;
            }

            $chartDays[] = [
                'day' => $date->format('D'),
                'date' => $date->format('M d'),
                'users' => $usersCount,
                'designs' => $designsCount,
                'videos' => $videosCount,
                'media' => $designsCount + $videosCount,
                'total' => $totalDayActivity,
            ];
        }

        // Calculate bar pixel heights for SVG (max height 120px)
        foreach ($chartDays as &$dayItem) {
            $ratio = $maxDailyActivity > 0 ? ($dayItem['total'] / $maxDailyActivity) : 0;
            $mediaRatio = $maxDailyActivity > 0 ? ($dayItem['media'] / $maxDailyActivity) : 0;
            $userRatio = $maxDailyActivity > 0 ? ($dayItem['users'] / $maxDailyActivity) : 0;
            
            // Set min height of 10px if count > 0, otherwise baseline
            $dayItem['media_bar_h'] = $dayItem['media'] > 0 ? max(round($mediaRatio * 90), 14) : 0;
            $dayItem['user_bar_h'] = $dayItem['users'] > 0 ? max(round($userRatio * 90), 12) : 0;
            $dayItem['total_h'] = $dayItem['media_bar_h'] + $dayItem['user_bar_h'];
        }
        unset($dayItem);

        // 6. Top Categories with design counts
        $topCategories = Category::withCount('designs')
            ->orderByDesc('designs_count')
            ->take(4)
            ->get()
            ->map(function ($cat) use ($totalDesigns) {
                $count = $cat->designs_count ?? 0;
                $pct = $totalDesigns > 0 ? round(($count / $totalDesigns) * 100) : 0;
                return [
                    'id' => $cat->id,
                    'title' => $cat->title,
                    'count' => $count,
                    'pct' => $pct,
                ];
            });

        // 7. Recent Registrations (Latest 5 Users)
        $recentUsers = User::latest()->take(5)->get();

        // 8. Recent Designs (Latest 4 Designs)
        $recentDesigns = Design::with(['category', 'parentCategory'])->latest()->take(4)->get();

        // 9. Date Range Display
        $dateRangeText = Carbon::now()->startOfMonth()->format('M 1') . ' - ' . Carbon::now()->format('M d, Y');

        return [
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'verifiedUsers' => $verifiedUsers,
            'unverifiedUsers' => $unverifiedUsers,
            'newUsersThisMonth' => $newUsersThisMonth,
            'userGrowth' => $userGrowth,
            'totalDesigns' => $totalDesigns,
            'activeDesigns' => $activeDesigns,
            'premiumDesigns' => $premiumDesigns,
            'freeDesigns' => $freeDesigns,
            'newDesignsThisMonth' => $newDesignsThisMonth,
            'totalVideos' => $totalVideos,
            'activeVideos' => $activeVideos,
            'newVideosThisMonth' => $newVideosThisMonth,
            'totalPremiumTemplates' => $totalPremiumTemplates,
            'activePremiumTemplates' => $activePremiumTemplates,
            'totalCategories' => $totalCategories,
            'totalSubCategories' => $totalSubCategories,
            'totalCoupons' => $totalCoupons,
            'activeCoupons' => $activeCoupons,
            'totalSpecialDays' => $totalSpecialDays,
            'totalParties' => $totalParties,
            'totalAssets' => $totalAssets,
            'chartDays' => $chartDays,
            'maxDailyActivity' => $maxDailyActivity,
            'topCategories' => $topCategories,
            'recentUsers' => $recentUsers,
            'recentDesigns' => $recentDesigns,
            'dateRangeText' => $dateRangeText,
        ];
    }
}

