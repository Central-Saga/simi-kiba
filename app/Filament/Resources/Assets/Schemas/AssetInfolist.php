<?php

namespace App\Filament\Resources\Assets\Schemas;

use App\Models\Asset;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AssetInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('asset_code')
                    ->label('Kode Aset'),
                TextEntry::make('register_number')
                    ->label('Nomor Register')
                    ->placeholder('-'),
                TextEntry::make('name')
                    ->label('Nama Aset'),
                TextEntry::make('category')
                    ->label('Kategori'),
                TextEntry::make('quantity')
                    ->label('Jumlah')
                    ->numeric(),
                TextEntry::make('unit')
                    ->label('Satuan')
                    ->placeholder('-'),
                TextEntry::make('condition')
                    ->label('Kondisi')
                    ->badge(),
                TextEntry::make('location_id')
                    ->label('Lokasi')
                    ->numeric(),
                TextEntry::make('description')
                    ->label('Deskripsi')
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
                TextEntry::make('deleted_at')
                    ->label('Dihapus Pada')
                    ->dateTime()
                    ->visible(fn (Asset $record): bool => $record->trashed()),
            ]);
    }
}
