<?php

namespace App\Filament\Resources\StockRequests\Pages;

use App\Filament\Resources\StockRequests\StockRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStockRequests extends ListRecords
{
    protected static string $resource = StockRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \App\Filament\Actions\PdfAction::make(
                'Permintaan Stok',
                ['item_name', 'requester.name', 'quantity', 'status', 'request_date'],
                ['Item', 'Pemohon', 'Jumlah', 'Status', 'Tanggal']
            ),
            \Filament\Actions\ExportAction::make()
                ->exporter(\App\Filament\Exports\StockRequestExporter::class)
                ->label('Ekspor Data'),
            CreateAction::make(),
        ];
    }
}
