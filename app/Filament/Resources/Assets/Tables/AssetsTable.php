<?php

namespace App\Filament\Resources\Assets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset_code')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('category')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Total Quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_used')
                    ->label('Digunakan')
                    ->numeric(),
                TextColumn::make('total_mutated')
                    ->label('Dimutasi')
                    ->numeric(),
                TextColumn::make('total_available')
                    ->label('Tersedia')
                    ->numeric(),
                TextColumn::make('unit')
                    ->label('Satuan')
                    ->searchable(),
                TextColumn::make('condition')
                    ->badge(),
                TextColumn::make('location.name')
                    ->label('Lokasi')
                    ->description(function (\App\Models\Asset $record) {
                        $mutations = $record->mutations()->with('toLocation')->get();
                        if ($mutations->isEmpty()) return null;
                        
                        $grouped = [];
                        foreach ($mutations as $m) {
                            $locName = $m->toLocation ? $m->toLocation->name : 'Unknown';
                            if (!isset($grouped[$locName])) {
                                $grouped[$locName] = 0;
                            }
                            $grouped[$locName] += $m->quantity;
                        }
                        
                        $details = [];
                        foreach ($grouped as $loc => $qty) {
                            $details[] = "Mutasi: {$qty} ke {$loc}";
                        }
                        return implode(', ', $details);
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
