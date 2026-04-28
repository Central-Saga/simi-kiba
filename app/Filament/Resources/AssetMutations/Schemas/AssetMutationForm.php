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
                    ->preload(),
                Select::make('from_location_id')
                    ->relationship('fromLocation', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
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
                    ->required(),
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
