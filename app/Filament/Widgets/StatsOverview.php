<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\AssetMutation;
use App\Models\StockRequest;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Aset', Asset::count())
                ->description('Jumlah seluruh aset terdaftar')
                ->descriptionIcon('heroicon-m-cube')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),
            Stat::make('Mutasi Bulan Ini', AssetMutation::whereMonth('mutation_date', now()->month)->count())
                ->description('Pergerakan aset bulan ini')
                ->descriptionIcon('heroicon-m-arrows-right-left')
                ->color('success'),
            Stat::make('Permintaan Stok Diajukan', StockRequest::where('status', 'diajukan')->count())
                ->description('Perlu persetujuan segera')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Total Pengguna', User::count())
                ->description('Petugas dan Administrator')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}
