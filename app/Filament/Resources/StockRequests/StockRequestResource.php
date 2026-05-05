<?php

namespace App\Filament\Resources\StockRequests;

use App\Filament\Resources\StockRequests\Pages\CreateStockRequest;
use App\Filament\Resources\StockRequests\Pages\EditStockRequest;
use App\Filament\Resources\StockRequests\Pages\ListStockRequests;
use App\Filament\Resources\StockRequests\Pages\ViewStockRequest;
use App\Filament\Resources\StockRequests\Schemas\StockRequestForm;
use App\Filament\Resources\StockRequests\Schemas\StockRequestInfolist;
use App\Filament\Resources\StockRequests\Tables\StockRequestsTable;
use App\Models\StockRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StockRequestResource extends Resource
{
    protected static ?string $model = StockRequest::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string|\UnitEnum|null $navigationGroup = 'Inventaris';

    protected static ?string $navigationLabel = 'Permintaan Stok';

    public static function form(Schema $schema): Schema
    {
        return StockRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StockRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StockRequestsTable::configure($table);
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
            'index' => ListStockRequests::route('/'),
            'create' => CreateStockRequest::route('/create'),
            'view' => ViewStockRequest::route('/{record}'),
            'edit' => EditStockRequest::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->hasRole('administrator')) {
            return $query;
        }

        return $query->where('requested_by', auth()->id());
    }
}
