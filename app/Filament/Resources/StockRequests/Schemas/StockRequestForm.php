<?php

namespace App\Filament\Resources\StockRequests\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class StockRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('requested_by')
                    ->relationship('requester', 'name')
                    ->default(auth()->id())
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('item_name')
                    ->required(),
                TextInput::make('quantity')
                    ->numeric()
                    ->required(),
                DatePicker::make('request_date')
                    ->default(now())
                    ->required(),
                Select::make('status')
                    ->options([
                        'diajukan' => 'Diajukan',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ])
                    ->default('diajukan')
                    ->required(),
                Select::make('approved_by')
                    ->relationship('approver', 'name')
                    ->searchable()
                    ->preload(),
                DateTimePicker::make('approved_at'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
