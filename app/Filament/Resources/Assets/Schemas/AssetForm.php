<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('asset_code')
                    ->default(function () {
                        $lastAsset = \App\Models\Asset::latest('id')->first();
                        $nextId = $lastAsset ? $lastAsset->id + 1 : 1;
                        return 'AST-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
                    })
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->readOnly(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('category')
                    ->required(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('unit')
                    ->label('Satuan (Pcs, Box, dll)')
                    ->placeholder('Contoh: Pcs, Unit, Kg')
                    ->required(),
                Select::make('condition')
                    ->options(['baik' => 'Baik', 'cukup' => 'Cukup', 'rusak' => 'Rusak'])
                    ->default('baik')
                    ->required(),
                Select::make('location_id')
                    ->relationship('location', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}
