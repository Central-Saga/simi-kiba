<?php

namespace App\Filament\Resources\Assets\Pages;

use App\Filament\Resources\Assets\AssetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAssets extends ListRecords
{
    protected static string $resource = AssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \App\Filament\Actions\PdfAction::make(
                'Aset Inventaris',
                ['asset_code', 'name', 'category', 'quantity', 'unit', 'condition'],
                ['Kode', 'Nama Aset', 'Kategori', 'Jumlah', 'Satuan', 'Kondisi']
            ),
            \Filament\Actions\ExportAction::make()
                ->exporter(\App\Filament\Exports\AssetExporter::class)
                ->label('Ekspor Data'),
            CreateAction::make(),
        ];
    }
}
