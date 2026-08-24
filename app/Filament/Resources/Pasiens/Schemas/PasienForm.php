<?php

namespace App\Filament\Resources\Pasiens\Schemas;

use App\Models\Country;
use App\Models\District;
use App\Models\Province;
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
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PasienForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. DATA IDENTITAS (4 COLUMNS DENGAN TOGGLE STATUS DI HEADER SEPERTI PEGAWAI)
                Section::make('Data Identitas')
                    ->icon('heroicon-o-identification')
                    ->columnSpanFull()
                    ->columns(4)
                    ->afterHeader([
                        Toggle::make('status_pasien')
                            ->label('Status Pasien')
                            ->inline(false)
                            ->formatStateUsing(fn($state) => $state === 'Hidup' || $state === true || $state === 1 || empty($state))
                            ->dehydrateStateUsing(fn($state) => $state ? 'Hidup' : 'Meninggal'),
                    ])
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
                            ->maxLength(10)
                            ->unique(ignoreRecord: true)
                            ->required(),

                        TextInput::make('gelar_depan')
                            ->label('Gelar Depan'),

                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required(),

                        TextInput::make('gelar_belakang')
                            ->label('Gelar Belakang'),

                        TextInput::make('nama_panggilan')
                            ->label('Nama Panggilan'),

                        Select::make('tempat_lahir_regency_id')
                            ->label('Tempat Lahir')
                            ->relationship('tempatLahir', 'name')
                            ->searchable()
                            ->preload(),

                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->displayFormat('d/m/Y'),

                        Select::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->options([
                                'Laki-Laki' => 'Laki-Laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required(),

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
                            ->default(fn($record) => $record ? $record->country_id : Country::where('code', 'ID')->value('id')),

                        Toggle::make('pasien_tidak_dikenal')
                            ->label('Pasien Tidak Dikenal')
                            ->inline(false)
                            ->default(false),
                    ]),

                // 2. ASAL INSTANSI / UNIT EKSTERNAL
                Section::make('Asal Instansi / Unit Eksternal')
                    ->icon('heroicon-o-building-office')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Select::make('unit_eksternal_id')
                            ->label('Unit Eksternal')
                            ->placeholder('[ Pilih Unit Eksternal ]')
                            ->options(fn() => UnitEksternal::whereNull('parent_id')->pluck('nama', 'id'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn($set) => $set('sub_unit_eksternal_id', null)),

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
                            ->disabled(fn($get) => blank($get('unit_eksternal_id'))),
                    ]),

                // 3. GRID 2 KOLOM: KARTU IDENTITAS & ALAMAT SEKARANG (PERSIS SEPERTI PEGAWAI)
                Grid::make(2)
                    ->columnSpanFull()
                    ->schema([
                        Section::make('Kartu Identitas')
                            ->icon('heroicon-o-identification')
                            ->columns(2)
                            ->schema([
                                Toggle::make('sama_dengan_alamat_sekarang')
                                    ->label('Sama Dengan Alamat Sekarang')
                                    ->live()
                                    ->columnSpanFull(),

                                self::referensiSelect('jenis_kartu_detail_id', 'Jenis Kartu Identitas', 'Jenis Kartu Identitas')
                                    ->columnSpan(1),

                                TextInput::make('nomor_kartu')
                                    ->label('Nomor Kartu')
                                    ->columnSpan(1),

                                Textarea::make('alamat_kartu')
                                    ->label('Alamat')
                                    ->rows(2)
                                    ->columnSpanFull()
                                    ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),

                                TextInput::make('rt_kartu')->label('RT')
                                    ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),
                                TextInput::make('rw_kartu')->label('RW')
                                    ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),
                                TextInput::make('kode_pos_kartu')->label('Kode Pos')->columnSpanFull()
                                    ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),

                                Select::make('province_id_kartu')
                                    ->label('Propinsi')
                                    ->options(fn() => Province::pluck('name', 'code'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $regencyId = $get('regency_id_kartu');
                                        if ($regencyId && ! Regency::where('code', $regencyId)->where('code', 'like', $get('province_id_kartu') . '.%')->exists()) {
                                            $set('regency_id_kartu', null);
                                            $set('district_id_kartu', null);
                                            $set('village_id_kartu', null);
                                        }
                                    })
                                    ->columnSpanFull()
                                    ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),

                                Select::make('regency_id_kartu')
                                    ->label('Kabupaten / Kota')
                                    ->options(fn($get) => $get('province_id_kartu')
                                        ? Regency::where('code', 'like', $get('province_id_kartu') . '.%')->pluck('name', 'code')
                                        : Regency::pluck('name', 'code'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $districtId = $get('district_id_kartu');
                                        if ($districtId && ! District::where('code', $districtId)->where('code', 'like', $get('regency_id_kartu') . '.%')->exists()) {
                                            $set('district_id_kartu', null);
                                            $set('village_id_kartu', null);
                                        }
                                    })
                                    ->columnSpanFull()
                                    ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),

                                Select::make('district_id_kartu')
                                    ->label('Kecamatan')
                                    ->options(fn($get) => $get('regency_id_kartu')
                                        ? District::where('code', 'like', $get('regency_id_kartu') . '.%')->pluck('name', 'code')
                                        : District::pluck('name', 'code'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $villageId = $get('village_id_kartu');
                                        if ($villageId && ! Village::where('code', $villageId)->where('code', 'like', $get('district_id_kartu') . '.%')->exists()) {
                                            $set('village_id_kartu', null);
                                        }
                                    })
                                    ->columnSpanFull()
                                    ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),

                                Select::make('village_id_kartu')
                                    ->label('Kelurahan / Desa')
                                    ->options(fn($get) => $get('district_id_kartu')
                                        ? Village::where('code', 'like', $get('district_id_kartu') . '.%')->pluck('name', 'code')
                                        : Village::pluck('name', 'code'))
                                    ->searchable()
                                    ->columnSpanFull()
                                    ->hidden(fn($get) => $get('sama_dengan_alamat_sekarang')),
                            ]),

                        Section::make('Alamat Sekarang')
                            ->icon('heroicon-o-map-pin')
                            ->columns(2)
                            ->schema([
                                Textarea::make('alamat')
                                    ->label('Alamat')
                                    ->rows(2)
                                    ->columnSpanFull(),

                                TextInput::make('rt')->label('RT'),
                                TextInput::make('rw')->label('RW'),
                                TextInput::make('kode_pos')->label('Kode Pos')->columnSpanFull(),

                                Select::make('province_id')
                                    ->label('Propinsi')
                                    ->relationship('province', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $regencyId = $get('regency_id');
                                        if ($regencyId && ! Regency::where('code', $regencyId)->where('code', 'like', $get('province_id') . '.%')->exists()) {
                                            $set('regency_id', null);
                                            $set('district_id', null);
                                            $set('village_id', null);
                                        }
                                    })
                                    ->columnSpanFull(),

                                Select::make('regency_id')
                                    ->label('Kabupaten / Kota')
                                    ->options(fn($get) => $get('province_id')
                                        ? Regency::where('code', 'like', $get('province_id') . '.%')->pluck('name', 'code')
                                        : Regency::pluck('name', 'code'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $districtId = $get('district_id');
                                        if ($districtId && ! District::where('code', $districtId)->where('code', 'like', $get('regency_id') . '.%')->exists()) {
                                            $set('district_id', null);
                                            $set('village_id', null);
                                        }
                                    })
                                    ->columnSpanFull(),

                                Select::make('district_id')
                                    ->label('Kecamatan')
                                    ->options(fn($get) => $get('regency_id')
                                        ? District::where('code', 'like', $get('regency_id') . '.%')->pluck('name', 'code')
                                        : District::pluck('name', 'code'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $villageId = $get('village_id');
                                        if ($villageId && ! Village::where('code', $villageId)->where('code', 'like', $get('district_id') . '.%')->exists()) {
                                            $set('village_id', null);
                                        }
                                    })
                                    ->columnSpanFull(),

                                Select::make('village_id')
                                    ->label('Kelurahan / Desa')
                                    ->options(fn($get) => $get('district_id')
                                        ? Village::where('code', 'like', $get('district_id') . '.%')->pluck('name', 'code')
                                        : Village::pluck('name', 'code'))
                                    ->searchable()
                                    ->columnSpanFull(),
                            ]),
                    ]),

                // 4. KONTAK (REPEATER SEPERTI PEGAWAI DENGAN 2 KOLOM)
                Section::make('Kontak')
                    ->icon('heroicon-o-phone')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('kontaks')
                            ->relationship()
                            ->label('')
                            ->columns(2)
                            ->schema([
                                TextInput::make('nomor_kontak')
                                    ->label('Nomor')
                                    ->placeholder('Contoh: 081234567890')
                                    ->required(),

                                self::referensiSelect('jenis_kontak_detail_id', 'Jenis Kontak', 'Jenis Kontak')
                                    ->required(),
                            ])
                            ->defaultItems(1)
                            ->addActionLabel('+ Tambah Kontak')
                            ->reorderable(false),
                    ]),

                // 5. KELUARGA (REPEATER RAPI DENGAN 4 KOLOM)
                Section::make('Keluarga')
                    ->icon('heroicon-o-users')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('keluargas')
                            ->relationship()
                            ->label('')
                            ->columns(4)
                            ->schema([
                                self::referensiSelect('status_keluarga_detail_id', 'Status Hubungan Keluarga', 'Status Hubungan Dalam Keluarga'),
                                TextInput::make('nama')->label('Nama Lengkap')->required(),
                                DatePicker::make('tanggal_lahir')->label('Tanggal Lahir')->displayFormat('d/m/Y'),
                                Select::make('jenis_kelamin')->label('Jenis Kelamin')->options([
                                    'Laki-Laki' => 'Laki-Laki',
                                    'Perempuan' => 'Perempuan',
                                ]),

                                self::referensiSelect('pendidikan_detail_id', 'Pendidikan', 'Pendidikan'),
                                self::referensiSelect('pekerjaan_detail_id', 'Pekerjaan', 'Pekerjaan'),
                                self::referensiSelect('jenis_kartu_detail_id', 'Jenis Kartu Identitas', 'Jenis Kartu Identitas'),
                                TextInput::make('nomor_kartu')->label('Nomor Kartu'),

                                Textarea::make('alamat')->label('Alamat')->rows(2)->columnSpan(2),
                                TextInput::make('telepon_seluler')->label('Telepon Seluler')->placeholder('Contoh: 081234567890')->columnSpan(2),

                                TextInput::make('rt')->label('RT'),
                                TextInput::make('rw')->label('RW'),
                                TextInput::make('kode_pos')->label('Kode Pos'),
                                Select::make('province_id')
                                    ->label('Propinsi')
                                    ->options(fn() => Province::pluck('name', 'code'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(fn($state, $set, $old) => $old !== null ? $set('regency_id', null) : null),

                                Select::make('regency_id')
                                    ->label('Kabupaten / Kota')
                                    ->options(fn($get) => $get('province_id')
                                        ? Regency::where('code', 'like', $get('province_id') . '.%')->pluck('name', 'code')
                                        : Regency::pluck('name', 'code'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(fn($state, $set, $old) => $old !== null ? $set('district_id', null) : null),

                                Select::make('district_id')
                                    ->label('Kecamatan')
                                    ->options(fn($get) => $get('regency_id')
                                        ? District::where('code', 'like', $get('regency_id') . '.%')->pluck('name', 'code')
                                        : District::pluck('name', 'code'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(fn($state, $set, $old) => $old !== null ? $set('village_id', null) : null),

                                Select::make('village_id')
                                    ->label('Kelurahan / Desa')
                                    ->options(fn($get) => $get('district_id')
                                        ? Village::where('code', 'like', $get('district_id') . '.%')->pluck('name', 'code')
                                        : Village::pluck('name', 'code'))
                                    ->searchable(),
                            ])
                            ->defaultItems(1)
                            ->addActionLabel('+ Tambah Keluarga')
                            ->reorderable(false),
                    ]),
            ]);
    }

    /**
     * Select untuk field yang merujuk ke referensi_details, difilter berdasarkan nama kategori referensi.
     */
    protected static function referensiSelect(string $fieldName, string $label, string $namaReferensi): Select
    {
        return Select::make($fieldName)
            ->label($label)
            ->placeholder("[ Pilih {$label} ]")
            ->options(fn() => ReferensiDetail::whereHas(
                'referensi',
                fn($query) => $query->whereRaw('LOWER(TRIM(nama)) = ?', [strtolower(trim($namaReferensi))])
            )->pluck('deskripsi', 'id'))
            ->searchable()
            ->preload();
    }
}
