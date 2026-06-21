<?php

namespace App\Filament\Resources\AssetUsages\Schemas;

use App\Models\Asset;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

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
                            $asset = Asset::find($state);
                            if ($asset) {
                                $set('location_id', $asset->location_id);
                            }
                        }
                    }),
                Select::make('user_id')
                    ->label('Pengguna')
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
                    ->label('Tanggal Penggunaan')
                    ->default(now())
                    ->required(),
                TextInput::make('quantity')
                    ->label('Jumlah')
                    ->required()
                    ->numeric()
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
                                $fail("Jumlah penggunaan ({$value}) melebihi stok tersedia ({$available}).");
                            }
                        },
                    ]),
                Textarea::make('purpose')
                    ->label('Tujuan')
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->columnSpanFull(),
            ]);
    }
}
