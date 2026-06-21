<?php

namespace App\Filament\Resources\Assets\Schemas;

use App\Models\Asset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('asset_code')
                    ->label('Kode Aset')
                    ->default(function () {
                        $lastAsset = Asset::latest('id')->first();
                        $nextId = $lastAsset ? $lastAsset->id + 1 : 1;

                        return 'AST-'.str_pad($nextId, 3, '0', STR_PAD_LEFT);
                    })
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->readOnly(),
                TextInput::make('register_number')
                    ->label('Nomor Register')
                    ->default(function () {
                        $lastAsset = Asset::withTrashed()->latest('id')->first();
                        $lastSeq = 0;
                        if ($lastAsset && preg_match('/REG-(\d+)/', (string) $lastAsset->register_number, $m)) {
                            $lastSeq = (int) $m[1];
                        }
                        $nextId = $lastSeq + 1;
                        if ($nextId < 1) {
                            $nextId = 1;
                        }

                        return 'REG-'.str_pad((string) $nextId, 4, '0', STR_PAD_LEFT);
                    })
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->readOnly(),
                TextInput::make('name')
                    ->label('Nama Aset')
                    ->required(),
                TextInput::make('category')
                    ->label('Kategori')
                    ->required(),
                TextInput::make('quantity')
                    ->label('Jumlah')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('unit')
                    ->label('Satuan (Pcs, Box, dll)')
                    ->placeholder('Contoh: Pcs, Unit, Kg')
                    ->required(),
                Select::make('condition')
                    ->label('Kondisi')
                    ->options(['baik' => 'Baik', 'cukup' => 'Cukup', 'rusak' => 'Rusak'])
                    ->default('baik')
                    ->required(),
                Select::make('location_id')
                    ->label('Lokasi')
                    ->relationship('location', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
            ]);
    }
}
