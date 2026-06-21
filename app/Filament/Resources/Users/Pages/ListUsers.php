<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Actions\PdfAction;
use App\Filament\Exports\UserExporter;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            PdfAction::make(
                'Pengguna',
                ['name', 'email', 'role', 'is_active'],
                ['Nama', 'Alamat Email', 'Peran', 'Aktif']
            ),
            ExportAction::make()
                ->exporter(UserExporter::class)
                ->label('Ekspor Data'),
            CreateAction::make(),
        ];
    }
}
