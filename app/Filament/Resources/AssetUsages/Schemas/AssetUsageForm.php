<?php

namespace App\Filament\Resources\AssetUsages\Schemas;

use Filament\Forms\Components\DatePicker;
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
                    ->relationship('asset', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {
                        if ($state) {
                            $asset = \App\Models\Asset::find($state);
                            if ($asset) {
                                $set('location_id', $asset->location_id);
                            }
                        }
                    }),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(auth()->id())
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('location_id')
                    ->label('Lokasi Pengambilan')
                    ->relationship('location', 'name')
                    ->required()
                    ->disabled()
                    ->dehydrated(),
                DatePicker::make('usage_date')
                    ->default(now())
                    ->required(),
                TextInput::make('quantity')
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
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
