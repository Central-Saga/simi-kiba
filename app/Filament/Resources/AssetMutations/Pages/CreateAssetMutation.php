<?php

namespace App\Filament\Resources\AssetMutations\Pages;

use App\Filament\Resources\AssetMutations\AssetMutationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAssetMutation extends CreateRecord
{
    protected static string $resource = AssetMutationResource::class;
}
