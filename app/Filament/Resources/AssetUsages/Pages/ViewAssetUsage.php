<?php

namespace App\Filament\Resources\AssetUsages\Pages;

use App\Filament\Resources\AssetUsages\AssetUsageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAssetUsage extends ViewRecord
{
    protected static string $resource = AssetUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
