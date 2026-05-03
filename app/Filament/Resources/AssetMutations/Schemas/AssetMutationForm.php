<?php

namespace App\Filament\Resources\AssetMutations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AssetMutationForm
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
                                $set('from_location_id', $asset->location_id);
                            }
                        }
                    }),
                Select::make('from_location_id')
                    ->relationship('fromLocation', 'name')
                    ->required()
                    ->disabled()
                    ->dehydrated(),
                Select::make('to_location_id')
                    ->relationship('toLocation', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                DatePicker::make('mutation_date')
                    ->default(now())
                    ->required(),
                TextInput::make('quantity')
                    ->numeric()
                    ->required()
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
                                $fail("Jumlah mutasi ({$value}) melebihi kuantitas tersedia ({$available}).");
                            }
                        },
                    ]),
                Select::make('created_by')
                    ->relationship('creator', 'name')
                    ->default(auth()->id())
                    ->required()
                    ->searchable()
                    ->preload(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
