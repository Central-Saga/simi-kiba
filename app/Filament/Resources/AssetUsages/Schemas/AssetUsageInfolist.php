<?php

namespace App\Filament\Resources\AssetUsages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AssetUsageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('asset.name')
                    ->label('Aset'),
                TextEntry::make('user.name')
                    ->label('Pengguna'),
                TextEntry::make('location.name')
                    ->label('Lokasi Aset'),
                TextEntry::make('usage_date')
                    ->label('Tanggal Penggunaan')
                    ->date(),
                TextEntry::make('quantity')
                    ->label('Jumlah')
                    ->numeric(),
                TextEntry::make('purpose')
                    ->label('Tujuan Penggunaan')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('notes')
                    ->label('Catatan')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
