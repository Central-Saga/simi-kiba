<?php

namespace App\Filament\Exports;

use App\Models\StockRequest;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class StockRequestExporter extends Exporter
{
    protected static ?string $model = StockRequest::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('requested_by'),
            ExportColumn::make('item_name'),
            ExportColumn::make('quantity'),
            ExportColumn::make('request_date'),
            ExportColumn::make('status'),
            ExportColumn::make('notes'),
            ExportColumn::make('approved_by'),
            ExportColumn::make('approved_at'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor permintaan stok telah selesai dan ' . Number::format($export->successful_rows) . ' ' . str('baris')->plural($export->successful_rows) . ' berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal diekspor.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return "permintaan-stok-{$export->getKey()}";
    }
}
