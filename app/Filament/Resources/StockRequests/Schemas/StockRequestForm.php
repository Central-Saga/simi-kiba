<?php

namespace App\Filament\Resources\StockRequests\Schemas;

use App\Models\Asset;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class StockRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('requested_by')
                    ->label('Pemohon')
                    ->relationship('requester', 'name')
                    ->default(auth()->id())
                    ->required()
                    ->searchable()
                    ->preload(),

                DatePicker::make('request_date')
                    ->label('Tanggal Permintaan')
                    ->default(now())
                    ->required(),

                Radio::make('request_type')
                    ->label('Tipe Permintaan')
                    ->options([
                        'existing' => 'Gunakan aset yang sudah ada',
                        'new' => 'Item baru',
                    ])
                    ->default('existing')
                    ->live(),

                Select::make('existing_item_name')
                    ->label('Pilih Aset')
                    ->options(Asset::pluck('name', 'name'))
                    ->visible(fn (Get $get) => $get('request_type') === 'existing')
                    ->required(fn (Get $get) => $get('request_type') === 'existing')
                    ->searchable(),

                TextInput::make('new_item_name')
                    ->label('Nama Item Baru')
                    ->visible(fn (Get $get) => $get('request_type') === 'new')
                    ->required(fn (Get $get) => $get('request_type') === 'new'),

                TextInput::make('quantity')
                    ->label('Jumlah')
                    ->numeric()
                    ->minValue(1)
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'diajukan' => 'Diajukan',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ])
                    ->default('diajukan')
                    ->required(),

                Textarea::make('notes')
                    ->label('Catatan')
                    ->columnSpanFull(),
            ]);
    }
}
