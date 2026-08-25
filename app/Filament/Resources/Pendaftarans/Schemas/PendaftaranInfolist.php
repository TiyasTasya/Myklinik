<?php

namespace App\Filament\Resources\Pendaftarans\Schemas;

use App\Models\Pendaftaran;
use Carbon\Carbon;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PendaftaranInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. CARD PROFIL PASIEN (PERSIS DENGAN INFOLIST PASIEN)
                Section::make()
                    ->schema([
                        Grid::make(12)
                            ->schema([
                                // Foto Avatar Pasien
                                Grid::make(1)
                                    ->columnSpan(2)
                                    ->schema([
                                        Section::make()
                                            ->schema([
                                                ImageEntry::make('profile_foto')
                                                    ->hiddenLabel()
                                                    ->getStateUsing(function (Pendaftaran $record) {
                                                        $jk = strtolower($record->pasien?->jenis_kelamin ?? '');

                                                        if (str_contains($jk, 'l') && !str_contains($jk, 'p')) {
                                                            return asset('profile/men.png');
                                                        } elseif (str_contains($jk, 'p')) {
                                                            return asset('profile/women.png');
                                                        }

                                                        return asset('profile/men.png');
                                                    })
                                                    ->size(110)
                                                    ->alignCenter(),
                                            ])
                                            ->compact()
                                            ->contained(true)
                                            ->extraAttributes([
                                                'class' => 'bg-gray-100 dark:bg-gray-800/60 rounded-xl',
                                            ]),
                                    ]),

                                // Kolom 1 Data Pasien (4 Kolom)
                                Grid::make(1)
                                    ->columnSpan(4)
                                    ->schema([
                                        TextEntry::make('pasien.no_rm')
                                            ->label('No. Rekam Medis')
                                            ->size('lg')
                                            ->weight('bold')
                                            ->placeholder('-'),

                                        TextEntry::make('nama_lengkap')
                                            ->label('Nama Lengkap')
                                            ->state(fn (Pendaftaran $record) => trim(
                                                collect([$record->pasien?->gelar_depan, $record->pasien?->nama, $record->pasien?->gelar_belakang])
                                                    ->filter()
                                                    ->join(' ')
                                            ))
                                            ->size('lg')
                                            ->weight('bold'),

                                        TextEntry::make('ttl')
                                            ->label('Tempat / Tanggal Lahir')
                                            ->state(fn (Pendaftaran $record) => collect([
                                                $record->pasien?->tempatLahir?->name,
                                                optional($record->pasien?->tanggal_lahir)->translatedFormat('d F Y'),
                                            ])->filter()->join(' / '))
                                            ->placeholder('-'),

                                        TextEntry::make('umur')
                                            ->label('Umur')
                                            ->state(function (Pendaftaran $record) {
                                                if (blank($record->pasien?->tanggal_lahir)) {
                                                    return null;
                                                }
                                                $diff = Carbon::parse($record->pasien->tanggal_lahir)->diff(now());
                                                return "{$diff->y}th {$diff->m}bln {$diff->d}hr";
                                            })
                                            ->placeholder('-'),

                                        TextEntry::make('pasien.agama.deskripsi')
                                            ->label('Agama')
                                            ->placeholder('-'),

                                        TextEntry::make('pasien.jenis_kelamin')
                                            ->label('Jenis Kelamin')
                                            ->badge(),
                                    ]),

                                // Kolom 2 & 3 Data Pasien (6 Kolom dengan Grid 2)
                                Grid::make(2)
                                    ->columnSpan(6)
                                    ->schema([
                                        TextEntry::make('pasien.pendidikan.deskripsi')
                                            ->label('Pendidikan')
                                            ->placeholder('-'),

                                        TextEntry::make('pasien.pekerjaan.deskripsi')
                                            ->label('Pekerjaan')
                                            ->placeholder('-'),

                                        TextEntry::make('pasien.statusPerkawinan.deskripsi')
                                            ->label('Status Perkawinan')
                                            ->placeholder('-'),

                                        TextEntry::make('pasien.golonganDarah.deskripsi')
                                            ->label('Gol. Darah')
                                            ->placeholder('-'),

                                        TextEntry::make('pasien.sukuBangsa.deskripsi')
                                            ->label('Suku Bangsa')
                                            ->placeholder('-'),

                                        TextEntry::make('pasien.country.name')
                                            ->label('Kewarganegaraan')
                                            ->placeholder('-'),

                                        TextEntry::make('pasien.alamat')
                                            ->label('Alamat')
                                            ->placeholder('-')
                                            ->columnSpan(2),

                                        TextEntry::make('rt_rw')
                                            ->label('RT / RW / Kode Pos')
                                            ->state(fn (Pendaftaran $record) => "RT " . ($record->pasien?->rt ?? '-') . " / RW " . ($record->pasien?->rw ?? '-') . " (Pos: " . ($record->pasien?->kode_pos ?? '-') . ")")
                                            ->columnSpan(2),

                                        TextEntry::make('wilayah')
                                            ->label('Wilayah (Kel / Kec / Kab / Prov)')
                                            ->state(fn (Pendaftaran $record) => collect([
                                                $record->pasien?->village?->name,
                                                $record->pasien?->district?->name,
                                                $record->pasien?->regency?->name,
                                                $record->pasien?->province?->name,
                                            ])->filter()->join(', '))
                                            ->placeholder('-')
                                            ->columnSpan(2),
                                    ]),
                            ]),
                    ]),

                // TABS DETAIL IDENTITAS, KELUARGA, KONTAK (PERSIS DENGAN INFOLIST PASIEN)
                Tabs::make('Detail Pasien')
                    ->tabs([
                        Tab::make('Kartu Identitas')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                RepeatableEntry::make('kartu_identitas')
                                    ->label('')
                                    ->state(fn (Pendaftaran $record) => $record->pasien?->nomor_kartu || $record->pasien?->jenis_kartu_detail_id
                                        ? [[
                                            'no_kartu' => $record->pasien->nomor_kartu,
                                            'jenis' => $record->pasien->jenisKartu?->deskripsi,
                                            'alamat' => $record->pasien->sama_dengan_alamat_sekarang ? $record->pasien->alamat : $record->pasien->alamat_kartu,
                                            'kelurahan' => $record->pasien->village?->name,
                                            'kecamatan' => $record->pasien->district?->name,
                                            'kabupaten' => $record->pasien->regency?->name,
                                            'provinsi' => $record->pasien->province?->name,
                                        ]]
                                        : [])
                                    ->schema([
                                        Grid::make(7)
                                            ->schema([
                                                TextEntry::make('no_kartu')->label('No. Kartu')->placeholder('-'),
                                                TextEntry::make('jenis')->label('Jenis')->placeholder('-'),
                                                TextEntry::make('alamat')->label('Alamat')->placeholder('-'),
                                                TextEntry::make('kelurahan')->label('Kelurahan')->placeholder('-'),
                                                TextEntry::make('kecamatan')->label('Kecamatan')->placeholder('-'),
                                                TextEntry::make('kabupaten')->label('Kabupaten / Kota')->placeholder('-'),
                                                TextEntry::make('provinsi')->label('Provinsi')->placeholder('-'),
                                            ]),
                                    ])
                                    ->contained(false),
                            ]),

                        Tab::make('Kartu Jaminan / Asuransi')
                            ->icon('heroicon-o-shield-check')
                            ->schema([
                                // Tab asuransi / jaminan
                            ]),

                        Tab::make('Keluarga Pasien')
                            ->icon('heroicon-o-users')
                            ->schema([
                                RepeatableEntry::make('pasien.keluargas')
                                    ->label('')
                                    ->schema([
                                        Grid::make(7)
                                            ->schema([
                                                TextEntry::make('statusKeluarga.deskripsi')->label('SHDK')->placeholder('-'),
                                                TextEntry::make('nama')->label('Nama')->placeholder('-'),
                                                TextEntry::make('jenis_kelamin')->label('Jenis Kelamin')->placeholder('-'),
                                                TextEntry::make('tanggal_lahir')->label('Tgl. Lahir')->date('d/m/Y')->placeholder('-'),
                                                TextEntry::make('pendidikan.deskripsi')->label('Pendidikan')->placeholder('-'),
                                                TextEntry::make('pekerjaan.deskripsi')->label('Pekerjaan')->placeholder('-'),
                                                TextEntry::make('telepon_seluler')->label('Telepon')->placeholder('-'),
                                            ]),
                                    ])
                                    ->contained(false),
                            ]),

                        Tab::make('Kontak')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                RepeatableEntry::make('pasien.kontaks')
                                    ->label('')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextEntry::make('jenisKontak.deskripsi')->label('Jenis Kontak')->placeholder('-'),
                                                TextEntry::make('nomor_kontak')->label('Nomor Kontak')->placeholder('-'),
                                            ]),
                                    ])
                                    ->contained(false),
                            ]),
                    ])
                    ->columnSpanFull(),

                // 2. DATA KUNJUNGAN SAAT INI
                Section::make('Data Kunjungan Saat Ini')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->columnSpanFull()
                    ->columns(4)
                    ->schema([
                        TextEntry::make('no_pendaftaran')
                            ->label('No. Registrasi')
                            ->weight('bold')
                            ->copyable(),

                        TextEntry::make('no_antrian')
                            ->label('No. Antrian')
                            ->badge()
                            ->color(fn (Pendaftaran $record): string => match ($record->status_pelayanan) {
                                'Menunggu' => 'primary',
                                'Sedang Diperiksa' => 'info',
                                default => 'gray',
                            })
                            ->weight('bold')
                            ->formatStateUsing(function (Pendaftaran $record, $state): ?string {
                                if (in_array($record->status_pelayanan, ['Selesai', 'Batal'])) {
                                    return '-';
                                }
                                return $state ? "Antrian #{$state}" : '-';
                            }),

                        TextEntry::make('tanggal_pendaftaran')
                            ->label('Waktu Pendaftaran')
                            ->dateTime('d/m/Y H:i:s'),

                        TextEntry::make('status_pelayanan')
                            ->label('Status Pelayanan')
                            ->badge()
                            ->colors([
                                'warning' => 'Menunggu',
                                'info'    => 'Sedang Diperiksa',
                                'success' => 'Selesai',
                                'danger'  => 'Batal',
                            ]),

                        TextEntry::make('jenis_pelayanan')
                            ->label('Jenis Pelayanan'),

                        TextEntry::make('poli.nama')
                            ->label('Poli Tujuan')
                            ->badge()
                            ->color('primary'),

                        TextEntry::make('dokter.nama_lengkap')
                            ->label('Dokter / DPJP')
                            ->placeholder('-'),

                        TextEntry::make('petugas.name')
                            ->label('Petugas Pendaftaran')
                            ->placeholder('-'),

                        TextEntry::make('pj_nama')
                            ->label('Penanggung Jawab')
                            ->state(fn (Pendaftaran $record): string => $record->pj_nama ? "{$record->pj_nama} ({$record->pj_hubungan})" : '-')
                            ->columnSpan(2),

                        TextEntry::make('catatan')
                            ->label('Catatan Pendaftaran')
                            ->placeholder('-')
                            ->columnSpan(2),
                    ]),

                // 3. RIWAYAT BEROBAT / HISTORY KUNJUNGAN PASIEN
                Section::make('Riwayat Berobat Pasien (History Kunjungan)')
                    ->icon('heroicon-o-clock')
                    ->columnSpanFull()
                    ->schema([
                        RepeatableEntry::make('pasien.pendaftarans')
                            ->label('Daftar Riwayat Kunjungan & Pelayanan Pasien')
                            ->columns(5)
                            ->schema([
                                TextEntry::make('no_pendaftaran')
                                    ->label('No. Registrasi')
                                    ->weight('bold')
                                    ->fontFamily('mono'),

                                TextEntry::make('tanggal_pendaftaran')
                                    ->label('Waktu Kunjungan')
                                    ->dateTime('d/m/Y H:i'),

                                TextEntry::make('poli.nama')
                                    ->label('Poli Layanan')
                                    ->badge()
                                    ->color('primary'),

                                TextEntry::make('dokter.nama_lengkap')
                                    ->label('Dokter / DPJP')
                                    ->placeholder('-'),

                                TextEntry::make('status_pelayanan')
                                    ->label('Status')
                                    ->badge()
                                    ->colors([
                                        'warning' => 'Menunggu',
                                        'info'    => 'Sedang Diperiksa',
                                        'success' => 'Selesai',
                                        'danger'  => 'Batal',
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
