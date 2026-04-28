<?php

namespace App\Filament\Resources\AssetMutations\Pages;

use App\Filament\Resources\AssetMutations\AssetMutationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAssetMutation extends EditRecord
{
    protected static string $resource = AssetMutationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
