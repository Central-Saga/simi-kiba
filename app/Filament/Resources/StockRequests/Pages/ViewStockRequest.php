<?php

namespace App\Filament\Resources\StockRequests\Pages;

use App\Filament\Resources\StockRequests\StockRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStockRequest extends ViewRecord
{
    protected static string $resource = StockRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $assetExists = \App\Models\Asset::where('name', $data['item_name'])->exists();
        
        if ($assetExists) {
            $data['request_type'] = 'existing';
            $data['existing_item_name'] = $data['item_name'];
        } else {
            $data['request_type'] = 'new';
            $data['new_item_name'] = $data['item_name'];
        }

        return $data;
    }
}
