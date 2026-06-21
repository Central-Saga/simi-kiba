<?php

namespace App\Filament\Resources\Assets\Tables;

use App\Models\Asset;
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
                TextColumn::make('rowIndex')
                    ->label('Nomor Urut')
                    ->rowIndex()
                    ->alignCenter()
                    ->extraHeaderAttributes(['class' => 'w-1']),
                TextColumn::make('register_number')
                    ->label('Nomor Register')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('asset_code')
                    ->label('Kode Aset')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama Aset')
                    ->searchable(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Jumlah Total')
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
                    ->label('Kondisi')
                    ->badge(),
                TextColumn::make('location.name')
                    ->label('Lokasi')
                    ->description(function (Asset $record) {
                        $mutations = $record->mutations()->with('toLocation')->get();
                        if ($mutations->isEmpty()) {
                            return null;
                        }

                        $grouped = [];
                        foreach ($mutations as $m) {
                            $locName = $m->toLocation ? $m->toLocation->name : 'Tidak Diketahui';
                            if (! isset($grouped[$locName])) {
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
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label('Dihapus Pada')
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
