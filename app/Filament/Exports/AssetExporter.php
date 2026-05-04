<?php

namespace App\Filament\Exports;

use App\Models\Asset;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class AssetExporter extends Exporter
{
    protected static ?string $model = Asset::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('asset_code'),
            ExportColumn::make('name'),
            ExportColumn::make('category'),
            ExportColumn::make('quantity'),
            ExportColumn::make('unit'),
            ExportColumn::make('condition'),
            ExportColumn::make('location_id'),
            ExportColumn::make('description'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('deleted_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor aset telah selesai dan ' . Number::format($export->successful_rows) . ' ' . str('baris')->plural($export->successful_rows) . ' berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal diekspor.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return "aset-inventaris-{$export->getKey()}";
    }
}
