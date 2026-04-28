<?php

namespace App\Filament\Resources\AssetUsages\Pages;

use App\Filament\Resources\AssetUsages\AssetUsageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAssetUsages extends ListRecords
{
    protected static string $resource = AssetUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
