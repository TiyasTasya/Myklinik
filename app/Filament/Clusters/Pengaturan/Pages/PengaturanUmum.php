<?php

namespace App\Filament\Clusters\Pengaturan\Pages;

use App\Filament\Clusters\Pengaturan;
use App\Models\Pengaturan as PengaturanModel;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PengaturanUmum extends Page implements HasForms
{
    use HasPageShield;
    use InteractsWithForms;

    protected static ?string $cluster = Pengaturan::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-paint-brush';

    protected static ?string $navigationLabel = 'Instansi';

    protected static ?string $title = 'Pengaturan Instansi';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.clusters.pengaturan.pages.pengaturan-umum';

    public ?array $data = [];

    public function mount(): void
    {
        $pengaturan = PengaturanModel::getPengaturan();
        $this->form->fill($pengaturan->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas & Informasi Klinik')
                    ->icon('heroicon-o-building-office-2')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nama_klinik')
                            ->label('Nama Klinik / Aplikasi')
                            ->placeholder('Contoh: Myklinik')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('brand_logo_height')
                            ->label('Tinggi Logo (CSS)')
                            ->placeholder('Contoh: 3rem')
                            ->default('3rem')
                            ->helperText('Ukuran tinggi logo di navigasi (contoh: 3rem, 45px).')
                            ->maxLength(50),
                    ]),

                Section::make('Logo & Favicon')
                    ->icon('heroicon-o-photo')
                    ->columns(3)
                    ->schema([
                        FileUpload::make('brand_logo')
                            ->label('Logo (Light Mode)')
                            ->image()
                            ->directory('settings/logo')
                            ->disk('public')
                            ->visibility('public')
                            ->imagePreviewHeight('120')
                            ->helperText('Format PNG/SVG transparan. Jika kosong, default logo/logo.png akan digunakan.'),

                        FileUpload::make('dark_mode_brand_logo')
                            ->label('Logo (Dark Mode)')
                            ->image()
                            ->directory('settings/logo')
                            ->disk('public')
                            ->visibility('public')
                            ->imagePreviewHeight('120')
                            ->helperText('Format PNG/SVG transparan untuk mode gelap. Jika kosong, default logo-dark.png akan digunakan.'),

                        FileUpload::make('favicon')
                            ->label('Favicon Browser')
                            ->image()
                            ->directory('settings/logo')
                            ->disk('public')
                            ->visibility('public')
                            ->imagePreviewHeight('120')
                            ->helperText('Ikon tab browser (PNG/ICO). Jika kosong, default favicon.png akan digunakan.'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $pengaturan = PengaturanModel::getPengaturan();
        $pengaturan->update($data);

        PengaturanModel::clearPengaturanCache();

        Notification::make()
            ->title('Pengaturan Berhasil Disimpan')
            ->body('Perubahan logo dan identitas klinik telah diperbarui.')
            ->success()
            ->send();
    }
}

