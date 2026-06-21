<?php

namespace App\Filament\Resources\Assets\Pages;

use App\Filament\Actions\PdfAction;
use App\Filament\Exports\AssetExporter;
use App\Filament\Resources\Assets\AssetResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListAssets extends ListRecords
{
    protected static string $resource = AssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            PdfAction::make(
                'Aset Inventaris',
                ['register_number', 'asset_code', 'name', 'category', 'quantity', 'unit', 'condition'],
                ['Nomor Register', 'Kode Aset', 'Nama Aset', 'Kategori', 'Jumlah', 'Satuan', 'Kondisi']
            ),
            ExportAction::make()
                ->exporter(AssetExporter::class)
                ->label('Ekspor Data'),
            CreateAction::make(),
        ];
    }
}
