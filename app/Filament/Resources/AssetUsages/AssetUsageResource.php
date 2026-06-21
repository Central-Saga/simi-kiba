<?php

namespace App\Filament\Resources\AssetUsages;

use App\Filament\Resources\AssetUsages\Pages\CreateAssetUsage;
use App\Filament\Resources\AssetUsages\Pages\EditAssetUsage;
use App\Filament\Resources\AssetUsages\Pages\ListAssetUsages;
use App\Filament\Resources\AssetUsages\Pages\ViewAssetUsage;
use App\Filament\Resources\AssetUsages\Schemas\AssetUsageForm;
use App\Filament\Resources\AssetUsages\Schemas\AssetUsageInfolist;
use App\Filament\Resources\AssetUsages\Tables\AssetUsagesTable;
use App\Models\AssetUsage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class AssetUsageResource extends Resource
{
    protected static ?string $model = AssetUsage::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clock';

    protected static string|\UnitEnum|null $navigationGroup = 'Inventaris';

    protected static ?string $modelLabel = 'Penggunaan Aset';

    protected static ?string $pluralModelLabel = 'Daftar Penggunaan Aset';

    public static function form(Schema $schema): Schema
    {
        return AssetUsageForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AssetUsageInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssetUsagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssetUsages::route('/'),
            'create' => CreateAssetUsage::route('/create'),
            'view' => ViewAssetUsage::route('/{record}'),
            'edit' => EditAssetUsage::route('/{record}/edit'),
        ];
    }
}
