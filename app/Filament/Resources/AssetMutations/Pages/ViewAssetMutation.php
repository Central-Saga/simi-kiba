<?php

namespace App\Filament\Resources\AssetMutations\Pages;

use App\Filament\Resources\AssetMutations\AssetMutationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAssetMutation extends ViewRecord
{
    protected static string $resource = AssetMutationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
