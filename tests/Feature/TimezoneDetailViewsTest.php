<?php

use App\Filament\Resources\AssetMutations\Schemas\AssetMutationInfolist;
use App\Filament\Resources\StockRequests\Schemas\StockRequestInfolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

it('uses Asia/Kuala_Lumpur as the application timezone', function () {
    expect(config('app.timezone'))->toBe('Asia/Kuala_Lumpur')
        ->and(now()->getTimezone()->getName())->toBe('Asia/Kuala_Lumpur');
});

it('renders asset mutation detail with timezone aware datetime entries', function () {
    $schema = AssetMutationInfolist::configure(Schema::make());

    $names = collect($schema->getComponents())
        ->filter(fn ($component) => $component instanceof TextEntry)
        ->map(fn (TextEntry $entry) => $entry->getName())
        ->all();

    expect($names)->toContain('mutation_date', 'created_at', 'updated_at');
});

it('renders stock request detail with timezone aware datetime entries', function () {
    $schema = StockRequestInfolist::configure(Schema::make());

    $names = collect($schema->getComponents())
        ->filter(fn ($component) => $component instanceof TextEntry)
        ->map(fn (TextEntry $entry) => $entry->getName())
        ->all();

    expect($names)->toContain('request_date', 'approved_at', 'created_at', 'updated_at');
});
