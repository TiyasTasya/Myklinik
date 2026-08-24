<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use FinityLabs\FinAvatar\AvatarProviders\UiAvatarsProvider;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationGroup;
use JeffersonGoncalves\Filament\RefreshSidebar\RefreshSidebarPlugin;
use Filament\Support\Icons\Heroicon;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->brandName(fn () => \App\Models\Pengaturan::getPengaturan()->nama_klinik ?? 'Myklinik')
            ->brandLogo(fn () => \App\Models\Pengaturan::getLogoUrl())
            ->darkModeBrandLogo(fn () => \App\Models\Pengaturan::getDarkModeLogoUrl())
            ->favicon(fn () => \App\Models\Pengaturan::getFaviconUrl())
            ->brandLogoHeight(fn () => \App\Models\Pengaturan::getLogoHeight())
            ->login()
            ->spa()
            ->font('Poppins')
            ->sidebarCollapsibleOnDesktop()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\Filament\Clusters')
            ->pages([
                Dashboard::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make()
                    ->modelLabel('Peran')
                    ->pluralModelLabel('Peran')
                    ->navigationLabel('Peran')
                    ->navigationGroup(null)
                    ->navigationSort(3),
                RefreshSidebarPlugin::make(),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->defaultAvatarProvider(UiAvatarsProvider::class)
            ->navigationGroups([
                NavigationGroup::make('Master')
                    ->icon(Heroicon::Folder),
            ])
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
