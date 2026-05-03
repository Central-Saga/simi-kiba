<?php

namespace App\Filament\Resources\StockRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Asset;
use App\Models\Location;
use App\Models\StockRequest;

class StockRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('requester.name')
                    ->label('Pemohon')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('item_name')
                    ->label('Item / Asset')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'diajukan' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('approver.name')
                    ->label('Approver')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('request_date')
                    ->label('Tanggal Request')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (StockRequest $record) => $record->status === 'diajukan')
                    ->action(function (StockRequest $record) {
                        DB::transaction(function () use ($record) {
                            $asset = Asset::where('name', $record->item_name)->first();
                            if ($asset) {
                                $asset->quantity += $record->quantity;
                                $asset->save();
                            } else {
                                $location = Location::firstOrCreate(
                                    ['code' => 'DEF'],
                                    ['name' => 'Default Location']
                                );
                                Asset::create([
                                    'asset_code' => 'REQ-' . strtoupper(Str::random(6)),
                                    'name' => $record->item_name,
                                    'category' => 'Uncategorized',
                                    'quantity' => $record->quantity,
                                    'unit' => 'pcs',
                                    'condition' => 'baik',
                                    'location_id' => $location->id,
                                ]);
                            }
                            $record->update([
                                'status' => 'disetujui',
                                'approved_by' => auth()->id(),
                                'approved_at' => now(),
                            ]);
                        });
                    }),
                Action::make('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (StockRequest $record) => $record->status === 'diajukan')
                    ->action(function (StockRequest $record) {
                        $record->update([
                            'status' => 'ditolak',
                            'approved_by' => auth()->id(),
                            'approved_at' => now(),
                        ]);
                    }),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
