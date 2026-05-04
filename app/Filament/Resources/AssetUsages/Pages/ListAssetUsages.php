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
            \App\Filament\Actions\PdfAction::make(
                'Penggunaan Aset',
                ['asset.name', 'user.name', 'usage_date', 'quantity', 'purpose'],
                ['Aset', 'Pengguna', 'Tanggal', 'Jumlah', 'Tujuan']
            ),
            \Filament\Actions\ExportAction::make()
                ->exporter(\App\Filament\Exports\AssetUsageExporter::class)
                ->label('Ekspor Data'),
            CreateAction::make(),
        ];
    }
}
