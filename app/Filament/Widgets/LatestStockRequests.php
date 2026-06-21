<?php

namespace App\Filament\Widgets;

use App\Models\StockRequest;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestStockRequests extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Permintaan Stok Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => StockRequest::query()->latest()->limit(5))
            ->columns([
                TextColumn::make('rowIndex')
                    ->label('Nomor Urut')
                    ->rowIndex()
                    ->alignCenter(),
                TextColumn::make('item_name')
                    ->label('Nama Barang')
                    ->searchable(),
                TextColumn::make('requester.name')
                    ->label('Pemohon'),
                TextColumn::make('quantity')
                    ->label('Jumlah')
                    ->alignCenter(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'diajukan' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Waktu Pengajuan')
                    ->dateTime()
                    ->since()
                    ->sortable(),
            ]);
    }
}
