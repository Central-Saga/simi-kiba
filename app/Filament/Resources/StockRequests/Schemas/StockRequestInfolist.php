<?php

namespace App\Filament\Resources\StockRequests\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StockRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('requester.name')
                    ->label('Pemohon'),
                TextEntry::make('item_name')
                    ->label('Nama Barang'),
                TextEntry::make('quantity')
                    ->label('Jumlah')
                    ->numeric(),
                TextEntry::make('request_date')
                    ->label('Tanggal Permintaan')
                    ->date(),
                TextEntry::make('status')
                    ->label('Status')
                    ->badge(),
                TextEntry::make('approver.name')
                    ->label('Penyetuju')
                    ->placeholder('-'),
                TextEntry::make('approved_at')
                    ->label('Disetujui Pada')
                    ->dateTime()
                    ->placeholder('-'),
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
