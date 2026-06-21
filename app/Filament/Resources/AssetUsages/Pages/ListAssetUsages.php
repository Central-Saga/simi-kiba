<?php

namespace App\Filament\Resources\AssetUsages\Pages;

use App\Filament\Actions\PdfAction;
use App\Filament\Exports\AssetUsageExporter;
use App\Filament\Resources\AssetUsages\AssetUsageResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListAssetUsages extends ListRecords
{
    protected static string $resource = AssetUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            PdfAction::make(
                'Penggunaan Aset',
                ['asset.register_number', 'asset.name', 'user.name', 'usage_date', 'quantity', 'purpose'],
                ['Nomor Register', 'Aset', 'Pengguna', 'Tanggal Penggunaan', 'Jumlah', 'Tujuan']
            ),
            ExportAction::make()
                ->exporter(AssetUsageExporter::class)
                ->label('Ekspor Data'),
            CreateAction::make(),
        ];
    }
}
