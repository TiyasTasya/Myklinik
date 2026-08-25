<?php

namespace App\Filament\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Lockscreen extends Page implements HasForms
{
    use InteractsWithForms;
    use WithRateLimiting;

    protected string $view = 'filament.auth.lockscreen';

    protected static string $layout = 'filament-panels::components.layout.simple';

    protected static ?string $slug = 'lockscreen';

    public ?array $data = [];

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public function hasLogo(): bool
    {
        return false;
    }

    public function mount(): void
    {
        if (! Filament::auth()->check()) {
            session()->forget(['is_locked', 'last_activity_time', 'url.intended']);
            $this->redirect(Filament::getLoginUrl(), navigate: false);

            return;
        }

        session(['is_locked' => true]);
        $this->form->fill();
    }

    public function getTitle(): string | Htmlable
    {
        return 'Sesi Terkunci';
    }

    public function getHeading(): string | Htmlable
    {
        return '';
    }

    public function getSubheading(): string | Htmlable | null
    {
        return null;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('password')
                    ->label('Password Akun')
                    ->password()
                    ->revealable()
                    ->required()
                    ->autofocus()
                    ->placeholder('Masukkan password Anda'),
            ])
            ->statePath('data');
    }

    public function authenticate(): void
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title('Terlalu banyak percobaan')
                ->body('Silakan tunggu ' . ceil($exception->secondsUntilAvailable) . ' detik lagi.')
                ->danger()
                ->send();

            return;
        }

        $data = $this->form->getState();
        $password = $data['password'] ?? '';
        $user = Filament::auth()->user();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'data.password' => 'Password yang Anda masukkan salah. Silakan coba lagi.',
            ]);
        }

        // Re-otentikasi dan perbarui sesi user agar selalu aktif
        Filament::auth()->login($user, remember: true);
        session()->regenerate();
        session()->forget(['is_locked', 'url.intended']);
        session(['last_activity_time' => time()]);

        Notification::make()
            ->title('Sesi Dibuka')
            ->body('Selamat datang kembali, ' . ($user->name ?? 'User') . '!')
            ->success()
            ->send();

        $this->redirect(route('filament.admin.pages.dashboard'));
    }

    public function logout(): void
    {
        session()->forget(['is_locked', 'last_activity_time', 'url.intended']);
        Filament::auth()->logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->redirect(Filament::getLoginUrl(), navigate: false);
    }
}
