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
            ExportColumn::make('asset.name')
                ->label('Aset'),
            ExportColumn::make('from_location_id')
                ->label('Lokasi Asal'),
            ExportColumn::make('to_location_id')
                ->label('Lokasi Tujuan'),
            ExportColumn::make('mutation_date')
                ->label('Tanggal Mutasi'),
            ExportColumn::make('quantity')
                ->label('Jumlah'),
            ExportColumn::make('notes')
                ->label('Catatan'),
            ExportColumn::make('created_by')
                ->label('Dibuat Oleh'),
            ExportColumn::make('created_at')
                ->label('Dibuat Pada'),
            ExportColumn::make('updated_at')
                ->label('Diperbarui Pada'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor mutasi aset telah selesai dan '.Number::format($export->successful_rows).' '.str('baris')->plural($export->successful_rows).' berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('baris')->plural($failedRowsCount).' gagal diekspor.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return "mutasi-aset-{$export->getKey()}";
    }
}
