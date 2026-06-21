<?php

namespace App\Filament\Resources\StockRequests\Pages;

use App\Filament\Actions\PdfAction;
use App\Filament\Exports\StockRequestExporter;
use App\Filament\Resources\StockRequests\StockRequestResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListStockRequests extends ListRecords
{
    protected static string $resource = StockRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            PdfAction::make(
                'Permintaan Stok',
                ['item_name', 'requester.name', 'quantity', 'status', 'request_date'],
                ['Nama Barang', 'Pemohon', 'Jumlah', 'Status', 'Tanggal Permintaan']
            ),
            ExportAction::make()
                ->exporter(StockRequestExporter::class)
                ->label('Ekspor Data'),
            CreateAction::make(),
        ];
    }
}
