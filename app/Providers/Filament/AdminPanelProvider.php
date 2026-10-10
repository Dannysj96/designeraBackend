<?php

namespace App\Providers\Filament;

use App\Filament\Pages\ApiTester;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Login;
use App\Filament\Pages\PremiumTemplates;
use App\Filament\Pages\Settings;
use App\Filament\Resources\Ads\AdsResource;
use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Coupons\CouponResource;
use App\Filament\Resources\DesignMaskings\DesignMaskingResource;
use App\Filament\Resources\Designs\DesignResource;
use App\Filament\Resources\ParentCategories\ParentCategoryResource;
use App\Filament\Resources\Parties\PartyResource;
use App\Filament\Resources\Plans\PlanResource;
use App\Filament\Resources\ReadyPhotos\ReadyPhotoResource;
use App\Filament\Resources\ReadyTexts\ReadyTextResource;
use App\Filament\Resources\RegularNotifications\RegularNotificationResource;
use App\Filament\Resources\Sliders\SliderResource;
use App\Filament\Resources\SpecialDays\SpecialDayResource;
use App\Filament\Resources\StaticNotifications\StaticNotificationResource;
use App\Filament\Resources\SubCategories\SubCategoryResource;
use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\Videos\VideoResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->brandLogo(fn () => view('filament.components.brand-logo'))
            ->brandLogoHeight('2.75rem')
            ->font('Inter')
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth(Width::Full)
            ->spa()
            ->darkMode()
            ->themeSwitcher()
            ->colors([
                'primary' => Color::Zinc,
                'gray' => Color::Zinc,
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => view('filament.components.sidebar-styles')
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => view('filament.components.login-styles'),
                scopes: Login::class
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->navigation(fn (NavigationBuilder $builder): NavigationBuilder => $builder
                ->group(NavigationGroup::make()->items([
                    ...Dashboard::getNavigationItems(),
                    ...UserResource::getNavigationItems(),
                ]))
                ->group(NavigationGroup::make('Designs')->items([
                    ...DesignResource::getNavigationItems(),
                    ...SpecialDayResource::getNavigationItems(),
                ]))
                ->group(NavigationGroup::make('Videos')->items([
                    ...VideoResource::getNavigationItems(),
                ]))
                ->group(NavigationGroup::make('Design Masking')->items([
                    ...DesignMaskingResource::getNavigationItems(),
                    ...ParentCategoryResource::getNavigationItems(),
                    ...CategoryResource::getNavigationItems(),
                    ...SubCategoryResource::getNavigationItems(),
                    ...ReadyPhotoResource::getNavigationItems(),
                    ...ReadyTextResource::getNavigationItems(),
                ]))
                ->group(NavigationGroup::make('Slider & Ads')->items([
                    ...SliderResource::getNavigationItems(),
                    ...AdsResource::getNavigationItems(),
                ]))
                ->group(NavigationGroup::make('Notifications')->items([
                    ...StaticNotificationResource::getNavigationItems(),
                    ...RegularNotificationResource::getNavigationItems(),
                ]))
                ->group(NavigationGroup::make()->items([
                    ...PlanResource::getNavigationItems(),
                ]))
                ->group(NavigationGroup::make('Party')->items([
                    ...PartyResource::getNavigationItems(),
                ]))
                ->group(NavigationGroup::make()->items([
                    ...CouponResource::getNavigationItems(),
                ]))
                ->group(NavigationGroup::make()->items([
                    ...ApiTester::getNavigationItems(),
                ]))
                ->group(NavigationGroup::make()->items([
                    ...Settings::getNavigationItems(),
                ])))
            ->pages([
                Dashboard::class,
                ApiTester::class,
                PremiumTemplates::class,
                Settings::class,
            ])
            ->widgets([])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
