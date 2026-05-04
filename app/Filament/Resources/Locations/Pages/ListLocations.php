<?php

namespace App\Filament\Resources\Locations\Pages;

use App\Filament\Resources\Locations\LocationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLocations extends ListRecords
{
    protected static string $resource = LocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \App\Filament\Actions\PdfAction::make(
                'Lokasi',
                ['code', 'name', 'description'],
                ['Kode', 'Nama Lokasi', 'Deskripsi']
            ),
            \Filament\Actions\ExportAction::make()
                ->exporter(\App\Filament\Exports\LocationExporter::class)
                ->label('Ekspor Data'),
            CreateAction::make(),
        ];
    }
}
