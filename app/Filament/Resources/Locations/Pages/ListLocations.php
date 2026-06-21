<?php

namespace App\Filament\Resources\Locations\Pages;

use App\Filament\Actions\PdfAction;
use App\Filament\Exports\LocationExporter;
use App\Filament\Resources\Locations\LocationResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListLocations extends ListRecords
{
    protected static string $resource = LocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            PdfAction::make(
                'Lokasi',
                ['code', 'name', 'description'],
                ['Kode Lokasi', 'Nama Lokasi', 'Deskripsi']
            ),
            ExportAction::make()
                ->exporter(LocationExporter::class)
                ->label('Ekspor Data'),
            CreateAction::make(),
        ];
    }
}
