<?php

namespace App\Filament\Resources\Pasiens\Schemas;

use App\Models\Country;
use App\Models\District;
use App\Models\Regency;
use App\Models\ReferensiDetail;
use App\Models\UnitEksternal;
use App\Models\Village;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PasienForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Identitas')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        TextInput::make('no_rm')
                            ->label('Nomor RM')
                            ->default(function () {
                                $last = \App\Models\Pasien::whereNotNull('no_rm')
                                    ->where('norm_manual', 'REGEXP', '^[0-9]+$')
                                    ->orderByRaw('CAST(norm_manual AS UNSIGNED) DESC')
                                    ->value('no_rm');

                                $next = $last ? ((int) $last) + 1 : 1;

                                return str_pad((string) $next, 5, '0', STR_PAD_LEFT);
                            })
                            ->maxLength(5)
                            ->unique(ignoreRecord: true)
                            ->required(),

                        TextInput::make('gelar_depan')
                            ->label('Gelar Depan')
                            ->columnSpanFull(),

                        TextInput::make('nama')
                            ->label('Nama Tanpa Gelar')
                            ->required()
                            ->columnSpanFull(),

                        TextInput::make('gelar_belakang')
                            ->label('Gelar Blkg')
                            ->columnSpanFull(),

                        TextInput::make('nama_panggilan')
                            ->label('Nama Panggilan')
                            ->columnSpanFull(),

                        Select::make('tempat_lahir_regency_id')
                            ->label('Tempat Lahir')
                            ->relationship('tempatLahir', 'name')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),

                        DatePicker::make('tanggal_lahir')
                            ->label('Tgl. Lahir')
                            ->displayFormat('d/m/Y')
                            ->columnSpanFull(),

                        Select::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->options([
                                'Laki-Laki' => 'Laki-Laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required()
                            ->columnSpanFull(),

                        self::referensiSelect('agama_detail_id', 'Agama', 'Agama'),
                        self::referensiSelect('status_perkawinan_detail_id', 'Status Perkawinan', 'Status Perkawinan'),
                        self::referensiSelect('pendidikan_detail_id', 'Pendidikan', 'Pendidikan'),
                        self::referensiSelect('pekerjaan_detail_id', 'Pekerjaan', 'Pekerjaan'),
                        self::referensiSelect('golongan_darah_detail_id', 'Golongan Darah', 'Golongan Darah'),
                        self::referensiSelect('suku_bangsa_detail_id', 'Suku Bangsa', 'Daftar Suku'),

                        Select::make('country_id')
                            ->label('Kewarganegaraan')
                            ->relationship('country', 'name')
                            ->searchable()
                            ->preload()
                            ->default(fn($record) => $record ? $record->country_id : Country::where('code', 'ID')->value('id'))
                            ->columnSpanFull(),

                        Select::make('status_pasien')
                            ->label('Status')
                            ->options([
                                'Hidup' => 'Hidup / Aktif',
                                'Meninggal' => 'Meninggal',
                            ])
                            ->default(fn($record) => $record ? $record->status_pasien : 'Hidup')
                            ->required()
                            ->columnSpanFull(),

                        Toggle::make('pasien_tidak_dikenal')
                            ->label('Pasien Tidak Dikenal')
                            ->default(false)
                            ->columnSpanFull(),
                    ]),

                Section::make('Asal Instansi / Unit Eksternal')
                    ->icon('heroicon-o-user-group')
                    ->schema([
                        Select::make('unit_eksternal_id')
                            ->label('Unit Eksternal')
                            ->placeholder('[ Pilih Unit Eksternal ]')
                            ->options(fn() => UnitEksternal::whereNull('parent_id')->pluck('nama', 'id'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn($set) => $set('sub_unit_eksternal_id', null))
                            ->columnSpanFull(),

                        Select::make('sub_unit_eksternal_id')
                            ->label('Sub Unit Eksternal')
                            ->placeholder('[ Pilih Sub Unit Eksternal ]')
                            ->options(function ($get) {
                                $parentId = $get('unit_eksternal_id');

                                return $parentId
                                    ? UnitEksternal::where('parent_id', $parentId)->pluck('nama', 'id')
                                    : [];
                            })
                            ->searchable()
                            ->disabled(fn($get) => blank($get('unit_eksternal_id')))
                            ->columnSpanFull(),
                    ]),

                Group::make([
                    Section::make('Alamat Sekarang')
                        ->icon('heroicon-o-map-pin')
                        ->schema([
                            Textarea::make('alamat')
                                ->label('Alamat')
                                ->rows(2)
                                ->columnSpanFull(),

                            TextInput::make('rt')->label('RT')->columnSpanFull(),
                            TextInput::make('rw')->label('RW')->columnSpanFull(),
                            TextInput::make('kode_pos')->label('Kode Pos')->columnSpanFull(),

                            Select::make('province_id')
                                ->label('Propinsi')
                                ->relationship('province', 'name')
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(fn($state, $set, $old) => $old !== null ? $set('regency_id', null) : null)
                                ->columnSpanFull(),

                            Select::make('regency_id')
                                ->label('Kabupaten / Kota')
                                ->options(fn($get) => $get('province_id')
                                    ? Regency::where('province_id', $get('province_id'))->pluck('name', 'id')
                                    : Regency::all()->pluck('name', 'id'))
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(fn($state, $set, $old) => $old !== null ? $set('district_id', null) : null)
                                ->columnSpanFull(),

                            Select::make('district_id')
                                ->label('Kecamatan')
                                ->options(fn($get) => $get('regency_id')
                                    ? District::where('regency_id', $get('regency_id'))->pluck('name', 'id')
                                    : District::all()->pluck('name', 'id'))
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(fn($state, $set, $old) => $old !== null ? $set('village_id', null) : null)
                                ->columnSpanFull(),

                            Select::make('village_id')
                                ->label('Kelurahan / Desa')
                                ->options(fn($get) => $get('district_id')
                                    ? Village::where('district_id', $get('district_id'))->pluck('name', 'id')
                                    : Village::all()->pluck('name', 'id'))
                                ->searchable()
                                ->columnSpanFull(),
                        ]),

                    Section::make('Kartu Identitas')
                        ->icon('heroicon-o-identification')
                        ->schema([
                            Toggle::make('sama_dengan_alamat_sekarang')
                                ->label('Sama Dengan Alamat Sekarang')
                                ->live()
                                ->columnSpanFull(),

                            self::referensiSelect('jenis_kartu_detail_id', 'Jenis Kartu Identitas', 'Jenis Kartu Identitas'),

                            TextInput::make('nomor_kartu')
                                ->label('Nomor Kartu')
                                ->columnSpanFull(),

                            Textarea::make('alamat_kartu')
                                ->label('Alamat')
                                ->rows(2)
                                ->columnSpanFull()
                                ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),

                            TextInput::make('rt_kartu')->label('RT')->columnSpanFull()
                                ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),
                            TextInput::make('rw_kartu')->label('RW')->columnSpanFull()
                                ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),
                            TextInput::make('kode_pos_kartu')->label('Kode Pos')->columnSpanFull()
                                ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),

                            Select::make('province_id_kartu')
                                ->label('Propinsi')
                                ->options(fn() => \App\Models\Province::pluck('name', 'id'))
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(fn($state, $set, $old) => $old !== null ? $set('regency_id_kartu', null) : null)
                                ->columnSpanFull()
                                ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),

                            Select::make('regency_id_kartu')
                                ->label('Kabupaten / Kota')
                                ->options(fn($get) => $get('province_id_kartu')
                                    ? Regency::where('province_id', $get('province_id_kartu'))->pluck('name', 'id')
                                    : Regency::all()->pluck('name', 'id'))
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(fn($state, $set, $old) => $old !== null ? $set('district_id_kartu', null) : null)
                                ->columnSpanFull()
                                ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),

                            Select::make('district_id_kartu')
                                ->label('Kecamatan')
                                ->options(fn($get) => $get('regency_id_kartu')
                                    ? District::where('regency_id', $get('regency_id_kartu'))->pluck('name', 'id')
                                    : District::all()->pluck('name', 'id'))
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(fn($state, $set, $old) => $old !== null ? $set('village_id_kartu', null) : null)
                                ->columnSpanFull()
                                ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),

                            Select::make('village_id_kartu')
                                ->label('Kelurahan / Desa')
                                ->options(fn($get) => $get('district_id_kartu')
                                    ? Village::where('district_id', $get('district_id_kartu'))->pluck('name', 'id')
                                    : Village::all()->pluck('name', 'id'))
                                ->searchable()
                                ->columnSpanFull()
                                ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),
                        ]),

                    Section::make('Kontak')
                        ->icon('heroicon-o-phone')
                        ->schema([
                            Repeater::make('kontaks')
                                ->relationship()
                                ->label('')
                                ->schema([
                                    self::referensiSelect('jenis_kontak_detail_id', 'Jenis Kontak', 'Jenis Kontak', showLabel: false),

                                    TextInput::make('nomor_kontak')
                                        ->placeholder('Contoh: 081234567890')
                                        ->required()
                                        ->columnSpanFull(),
                                ])
                                ->defaultItems(1)
                                ->addActionLabel('+ Tambah Kontak')
                                ->columnSpanFull(),
                        ]),

                    Section::make('Keluarga')
                        ->icon('heroicon-o-users')
                        ->schema([
                            Repeater::make('keluargas')
                                ->relationship()
                                ->label('')
                                ->schema([
                                    self::referensiSelect('status_keluarga_detail_id', 'Status Hubungan Keluarga', 'Status Hubungan Dalam Keluarga', showLabel: false),

                                    TextInput::make('nama')
                                        ->placeholder('Nama Keluarga tanpa Gelar')
                                        ->required()
                                        ->columnSpanFull(),

                                    DatePicker::make('tanggal_lahir')
                                        ->placeholder('Tgl. Lahir (tgl/bln/thn)')
                                        ->displayFormat('d/m/Y')
                                        ->columnSpanFull(),

                                    Select::make('jenis_kelamin')
                                        ->options([
                                            'Laki-Laki' => 'Laki-Laki',
                                            'Perempuan' => 'Perempuan',
                                        ])
                                        ->columnSpanFull(),

                                    self::referensiSelect('pendidikan_detail_id', 'Pendidikan', 'Pendidikan', showLabel: false),
                                    self::referensiSelect('pekerjaan_detail_id', 'Pekerjaan', 'Pekerjaan', showLabel: false),

                                    Textarea::make('alamat')
                                        ->placeholder('Masukan Alamat')
                                        ->rows(1)
                                        ->columnSpanFull(),

                                    self::referensiSelect('jenis_kartu_detail_id', 'Jenis Kartu Identitas', 'Jenis Kartu Identitas', showLabel: false),

                                    TextInput::make('nomor_kartu')
                                        ->placeholder('Nomor Kartu')
                                        ->columnSpanFull(),

                                    Textarea::make('alamat_kartu')
                                        ->placeholder('Alamat')
                                        ->rows(1)
                                        ->columnSpanFull(),

                                    TextInput::make('rt')->placeholder('RT')->columnSpanFull(),
                                    TextInput::make('rw')->placeholder('RW')->columnSpanFull(),
                                    TextInput::make('kode_pos')->placeholder('Kode Pos')->columnSpanFull(),

                                    Select::make('province_id')
                                        ->label('Propinsi')
                                        ->options(fn() => \App\Models\Province::pluck('name', 'id'))
                                        ->searchable()
                                        ->live()
                                        ->afterStateUpdated(fn($state, $set, $old) => $old !== null ? $set('regency_id', null) : null)
                                        ->columnSpanFull(),

                                    Select::make('regency_id')
                                        ->label('Kabupaten / Kota')
                                        ->options(fn($get) => $get('province_id')
                                            ? Regency::where('province_id', $get('province_id'))->pluck('name', 'id')
                                            : Regency::all()->pluck('name', 'id'))
                                        ->searchable()
                                        ->live()
                                        ->afterStateUpdated(fn($state, $set, $old) => $old !== null ? $set('district_id', null) : null)
                                        ->columnSpanFull(),

                                    Select::make('district_id')
                                        ->label('Kecamatan')
                                        ->options(fn($get) => $get('regency_id')
                                            ? District::where('regency_id', $get('regency_id'))->pluck('name', 'id')
                                            : District::all()->pluck('name', 'id'))
                                        ->searchable()
                                        ->live()
                                        ->afterStateUpdated(fn($state, $set, $old) => $old !== null ? $set('village_id', null) : null)
                                        ->columnSpanFull(),

                                    Select::make('village_id')
                                        ->label('Kelurahan / Desa')
                                        ->options(fn($get) => $get('district_id')
                                            ? Village::where('district_id', $get('district_id'))->pluck('name', 'id')
                                            : Village::all()->pluck('name', 'id'))
                                        ->searchable()
                                        ->columnSpanFull(),

                                    TextInput::make('telepon_seluler')
                                        ->label('Telepon Seluler')
                                        ->placeholder('Contoh: 081234567890')
                                        ->columnSpanFull(),
                                ])
                                ->defaultItems(1)
                                ->addActionLabel('+ Tambah Keluarga')
                                ->columnSpanFull(),
                        ]),
                ]),
            ]);
    }

    /**
     * Select untuk field yang merujuk ke referensi_details, difilter berdasarkan nama kategori referensi.
     */
    protected static function referensiSelect(string $fieldName, string $label, string $namaReferensi, bool $showLabel = true): Select
    {
        return Select::make($fieldName)
            ->label($showLabel ? $label : null)
            ->placeholder("[{$label}]")
            ->options(fn() => ReferensiDetail::whereHas(
                'referensi',
                fn($query) => $query->whereRaw('LOWER(TRIM(nama)) = ?', [strtolower(trim($namaReferensi))])
            )->pluck('deskripsi', 'id'))
            ->searchable()
            ->preload()
            ->columnSpanFull();
    }
}
