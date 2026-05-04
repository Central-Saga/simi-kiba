<?php

namespace App\Filament\Exports;

use App\Models\AssetMutation;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class AssetMutationExporter extends Exporter
{
    protected static ?string $model = AssetMutation::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('asset_id'),
            ExportColumn::make('from_location_id'),
            ExportColumn::make('to_location_id'),
            ExportColumn::make('mutation_date'),
            ExportColumn::make('quantity'),
            ExportColumn::make('notes'),
            ExportColumn::make('created_by'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor mutasi aset telah selesai dan ' . Number::format($export->successful_rows) . ' ' . str('baris')->plural($export->successful_rows) . ' berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal diekspor.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return "mutasi-aset-{$export->getKey()}";
    }
}
