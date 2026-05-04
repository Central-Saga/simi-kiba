<?php

namespace App\Filament\Actions;

use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Collection;

class PdfAction
{
    /**
     * Create a PDF export action
     * 
     * @param string $title Judul laporan
     * @param array $columns Nama kolom (key) pada model
     * @param array $headers Nama kolom (label) untuk header tabel di PDF
     */
    public static function make(string $title, array $columns, array $headers): Action
    {
        return Action::make('exportPdf')
            ->label('Cetak PDF')
            ->color('danger')
            ->icon('heroicon-o-document-text')
            ->action(function ($livewire) use ($title, $columns, $headers) {
                // Mengambil query yang sudah difilter dari tabel Filament
                $records = $livewire->getFilteredTableQuery()->get();
                
                $pdf = Pdf::loadView('pdf.report', [
                    'title' => $title,
                    'records' => $records,
                    'columns' => $columns,
                    'headers' => $headers,
                ])->setPaper('a4', 'landscape');

                // Generate filename: laporan-aset-inventaris-20240504.pdf
                $filename = 'laporan-' . str($title)->slug() . '-' . now()->format('YmdHis') . '.pdf';

                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf->output();
                }, $filename);
            });
    }
}
