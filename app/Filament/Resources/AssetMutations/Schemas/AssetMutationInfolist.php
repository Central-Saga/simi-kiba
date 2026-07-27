<?php

namespace App\Filament\Resources\AssetMutations\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AssetMutationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('asset.name')
                    ->label('Asset'),
                TextEntry::make('fromLocation.name')
                    ->label('From location'),
                TextEntry::make('toLocation.name')
                    ->label('To location'),
                TextEntry::make('mutation_date')
                    ->date(),
                TextEntry::make('quantity')
                    ->numeric(),
                TextEntry::make('creator.name')
                    ->label('Creator'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
