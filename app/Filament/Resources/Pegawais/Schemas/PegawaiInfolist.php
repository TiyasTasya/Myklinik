<?php

namespace App\Filament\Resources\Pegawais\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PegawaiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('Akun User Login')
                    ->placeholder('-'),

                TextEntry::make('nip')
                    ->label('NIP')
                    ->placeholder('-'),

                TextEntry::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->placeholder('-'),

                TextEntry::make('tempat_tanggal_lahir')
                    ->label('Tempat, Tanggal Lahir')
                    ->placeholder('-'),

                TextEntry::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Laki-laki' => 'info',
                        'Perempuan' => 'success',
                        default => 'gray',
                    }),

                TextEntry::make('alamat')
                    ->label('Alamat')
                    ->columnSpanFull()
                    ->placeholder('-'),

                TextEntry::make('profesi')
                    ->label('Profesi')
                    ->placeholder('-'),

                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Cuti' => 'warning',
                        'Nonaktif' => 'danger',
                        default => 'gray',
                    }),

                TextEntry::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
