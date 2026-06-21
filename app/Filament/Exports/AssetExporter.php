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
            ExportColumn::make('register_number')
                ->label('Nomor Register'),
            ExportColumn::make('asset_code')
                ->label('Kode Aset'),
            ExportColumn::make('name')
                ->label('Nama Aset'),
            ExportColumn::make('category')
                ->label('Kategori'),
            ExportColumn::make('quantity')
                ->label('Jumlah'),
            ExportColumn::make('unit')
                ->label('Satuan'),
            ExportColumn::make('condition')
                ->label('Kondisi'),
            ExportColumn::make('location_id')
                ->label('Lokasi'),
            ExportColumn::make('description')
                ->label('Deskripsi'),
            ExportColumn::make('created_at')
                ->label('Dibuat Pada'),
            ExportColumn::make('updated_at')
                ->label('Diperbarui Pada'),
            ExportColumn::make('deleted_at')
                ->label('Dihapus Pada'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor aset telah selesai dan '.Number::format($export->successful_rows).' '.str('baris')->plural($export->successful_rows).' berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('baris')->plural($failedRowsCount).' gagal diekspor.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return "aset-inventaris-{$export->getKey()}";
    }
}
