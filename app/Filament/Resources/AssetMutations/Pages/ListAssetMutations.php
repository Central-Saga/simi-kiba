<?php

namespace App\Filament\Resources\AssetMutations\Pages;

use App\Filament\Resources\AssetMutations\AssetMutationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAssetMutations extends ListRecords
{
    protected static string $resource = AssetMutationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \App\Filament\Actions\PdfAction::make(
                'Mutasi Aset',
                ['asset.name', 'fromLocation.name', 'toLocation.name', 'mutation_date', 'quantity'],
                ['Aset', 'Dari Lokasi', 'Ke Lokasi', 'Tanggal', 'Jumlah']
            ),
            \Filament\Actions\ExportAction::make()
                ->exporter(\App\Filament\Exports\AssetMutationExporter::class)
                ->label('Ekspor Data'),
            CreateAction::make(),
        ];
    }
}
