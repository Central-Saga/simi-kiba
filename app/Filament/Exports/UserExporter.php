<?php

namespace App\Filament\Exports;

use App\Models\User;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class UserExporter extends Exporter
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('name')
                ->label('Nama'),
            ExportColumn::make('email')
                ->label('Alamat Email'),
            ExportColumn::make('role')
                ->label('Peran'),
            ExportColumn::make('is_active')
                ->label('Aktif'),
            ExportColumn::make('created_at')
                ->label('Dibuat Pada'),
            ExportColumn::make('updated_at')
                ->label('Diperbarui Pada'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor pengguna telah selesai dan '.Number::format($export->successful_rows).' '.str('baris')->plural($export->successful_rows).' berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('baris')->plural($failedRowsCount).' gagal diekspor.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return "pengguna-{$export->getKey()}";
    }
}
