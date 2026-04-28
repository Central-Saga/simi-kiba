<?php

namespace App\Filament\Resources\AssetUsages\Pages;

use App\Filament\Resources\AssetUsages\AssetUsageResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAssetUsage extends EditRecord
{
    protected static string $resource = AssetUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
