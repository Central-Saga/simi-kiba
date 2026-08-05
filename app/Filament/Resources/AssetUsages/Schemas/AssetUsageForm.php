<?php

namespace App\Filament\Resources\AssetUsages\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AssetUsageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('asset_id')
                    ->label('Aset')
                    ->relationship('asset', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {
                        if ($state) {
                            $asset = \App\Models\Asset::with('location')->find($state);
                            if ($asset) {
                                $set('location_id', $asset->location_id);
                                $set('location_name', $asset->location?->name ?? '-');
                            }
                        } else {
                            $set('location_id', null);
                            $set('location_name', '');
                        }
                    }),
                Select::make('user_id')
                    ->label('Pengguna')
                    ->relationship('user', 'name')
                    ->default(auth()->id())
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('location_name')
                    ->label('Lokasi Aset')
                    ->disabled()
                    ->dehydrated(false)
                    ->afterStateHydrated(function ($component, $state, $record) {
                        if ($record && $record->location) {
                            $component->state($record->location->name);
                        }
                    }),
                Hidden::make('location_id')
                    ->required(),
                DatePicker::make('usage_date')
                    ->label('Tanggal Penggunaan')
                    ->default(now())
                    ->required(),
                TextInput::make('quantity')
                    ->label('Jumlah')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->rules([
                        fn (callable $get, ?\Illuminate\Database\Eloquent\Model $record): \Closure => function (string $attribute, $value, \Closure $fail) use ($get, $record) {
                            $assetId = $get('asset_id');

                            if (!$assetId) {
                                return;
                            }

                            $asset = \App\Models\Asset::find($assetId);
                            if (!$asset) return;

                            $available = $asset->total_available;

                            if ($record) {
                                $available += $record->quantity;
                            }

                            if ($value > $available) {
                                $fail("Jumlah penggunaan ({$value}) melebihi stok tersedia ({$available}).");
                            }
                        },
                    ]),
                Textarea::make('purpose')
                    ->label('Tujuan Penggunaan')
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->columnSpanFull(),
            ]);
    }
}
