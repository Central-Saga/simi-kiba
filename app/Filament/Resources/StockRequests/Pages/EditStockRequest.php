<?php

namespace App\Filament\Resources\StockRequests\Pages;

use App\Filament\Resources\StockRequests\StockRequestResource;
use App\Models\Asset;
use App\Models\Location;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EditStockRequest extends EditRecord
{
    protected static string $resource = StockRequestResource::class;

    protected ?string $oldStatus = null;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $assetExists = Asset::where('name', $data['item_name'])->exists();

        if ($assetExists) {
            $data['request_type'] = 'existing';
            $data['existing_item_name'] = $data['item_name'];
        } else {
            $data['request_type'] = 'new';
            $data['new_item_name'] = $data['item_name'];
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->oldStatus = $this->record->status;

        if (isset($data['request_type'])) {
            if ($data['request_type'] === 'existing') {
                $data['item_name'] = $data['existing_item_name'] ?? $data['item_name'];
            } else {
                $data['item_name'] = $data['new_item_name'] ?? $data['item_name'];
            }
        }

        unset($data['request_type']);
        unset($data['existing_item_name']);
        unset($data['new_item_name']);

        return $data;
    }

    protected function afterSave(): void
    {
        $record = $this->record;

        if ($this->oldStatus !== 'disetujui' && $record->status === 'disetujui') {
            DB::transaction(function () use ($record) {
                $asset = Asset::where('name', $record->item_name)->first();

                if ($asset) {
                    $asset->quantity += $record->quantity;
                    $asset->save();
                } else {
                    $location = Location::firstOrCreate(
                        ['code' => 'DEF'],
                        ['name' => 'Lokasi Default']
                    );

                    Asset::create([
                        'asset_code' => 'REQ-'.strtoupper(Str::random(6)),
                        'register_number' => 'REG-'.strtoupper(Str::random(6)),
                        'name' => $record->item_name,
                        'category' => 'Belum Dikategorikan',
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
