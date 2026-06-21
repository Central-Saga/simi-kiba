<?php

namespace App\Filament\Resources\AssetMutations\Pages;

use App\Filament\Actions\PdfAction;
use App\Filament\Exports\AssetMutationExporter;
use App\Filament\Resources\AssetMutations\AssetMutationResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListAssetMutations extends ListRecords
{
    protected static string $resource = AssetMutationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            PdfAction::make(
                'Mutasi Aset',
                ['asset.register_number', 'asset.name', 'fromLocation.name', 'toLocation.name', 'mutation_date', 'quantity'],
                ['Nomor Register', 'Aset', 'Dari Lokasi', 'Ke Lokasi', 'Tanggal Mutasi', 'Jumlah']
            ),
            ExportAction::make()
                ->exporter(AssetMutationExporter::class)
                ->label('Ekspor Data'),
            CreateAction::make(),
        ];
    }
}
