<?php

namespace App\Filament\Resources\AssetMutations\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AssetMutationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('asset.name')
                    ->label('Aset'),
                TextEntry::make('fromLocation.name')
                    ->label('Dari Lokasi'),
                TextEntry::make('toLocation.name')
                    ->label('Ke Lokasi'),
                TextEntry::make('mutation_date')
                    ->label('Tanggal Mutasi')
                    ->date(),
                TextEntry::make('quantity')
                    ->label('Jumlah')
                    ->numeric(),
                TextEntry::make('creator.name')
                    ->label('Dibuat Oleh'),
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
