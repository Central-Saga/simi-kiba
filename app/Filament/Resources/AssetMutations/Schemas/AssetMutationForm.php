<?php

namespace App\Filament\Resources\AssetMutations\Schemas;

use App\Models\Asset;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class AssetMutationForm
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
                            $asset = Asset::find($state);
                            if ($asset) {
                                $set('from_location_id', $asset->location_id);
                            }
                        }
                    }),
                Select::make('from_location_id')
                    ->label('Lokasi Asal')
                    ->relationship('fromLocation', 'name')
                    ->required()
                    ->disabled()
                    ->dehydrated(),
                Select::make('to_location_id')
                    ->label('Lokasi Tujuan')
                    ->relationship('toLocation', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                DatePicker::make('mutation_date')
                    ->label('Tanggal Mutasi')
                    ->default(now())
                    ->required(),
                TextInput::make('quantity')
                    ->label('Jumlah')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->rules([
                        fn (callable $get, ?Model $record): \Closure => function (string $attribute, $value, \Closure $fail) use ($get, $record) {
                            $assetId = $get('asset_id');

                            if (! $assetId) {
                                return;
                            }

                            $asset = Asset::find($assetId);
                            if (! $asset) {
                                return;
                            }

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
                    ->label('Dibuat Oleh')
                    ->relationship('creator', 'name')
                    ->default(auth()->id())
                    ->required()
                    ->searchable()
                    ->preload(),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->columnSpanFull(),
            ]);
    }
}
