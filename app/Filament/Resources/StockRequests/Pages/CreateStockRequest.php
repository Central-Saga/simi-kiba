<?php

namespace App\Filament\Resources\StockRequests\Pages;

use App\Filament\Resources\StockRequests\StockRequestResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateStockRequest extends CreateRecord
{
    protected static string $resource = StockRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['request_type'])) {
            if ($data['request_type'] === 'existing') {
                $data['item_name'] = $data['existing_item_name'] ?? null;
            } else {
                $data['item_name'] = $data['new_item_name'] ?? null;
            }
        }
        
        unset($data['request_type']);
        unset($data['existing_item_name']);
        unset($data['new_item_name']);
        
        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->record;

        if ($record->status === 'disetujui') {
            \Illuminate\Support\Facades\DB::transaction(function () use ($record) {
                $asset = \App\Models\Asset::where('name', $record->item_name)->first();

                if ($asset) {
                    $asset->quantity += $record->quantity;
                    $asset->save();
                } else {
                    $location = \App\Models\Location::firstOrCreate(
                        ['code' => 'DEF'],
                        ['name' => 'Default Location']
                    );
                    
                    \App\Models\Asset::create([
                        'asset_code' => 'REQ-' . strtoupper(Str::random(6)),
                        'name' => $record->item_name,
                        'category' => 'Uncategorized',
                        'quantity' => $record->quantity,
                        'unit' => 'pcs',
                        'condition' => 'baik',
                        'location_id' => $location->id,
                    ]);
                }

                $record->approved_by = auth()->id();
                $record->approved_at = now();
                $record->saveQuietly();
            });
        }
    }
}
