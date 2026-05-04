<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LatestStockRequests extends TableWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Permintaan Stok Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => \App\Models\StockRequest::query()->latest()->limit(5))
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('item_name')
                    ->label('Nama Item')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('requester.name')
                    ->label('Pemohon'),
                \Filament\Tables\Columns\TextColumn::make('quantity')
                    ->label('Jumlah')
                    ->alignCenter(),
                \Filament\Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Pengajuan')
                    ->dateTime()
                    ->since()
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
