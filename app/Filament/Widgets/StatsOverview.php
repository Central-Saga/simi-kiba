<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Aset', \App\Models\Asset::count())
                ->description('Jumlah seluruh aset terdaftar')
                ->descriptionIcon('heroicon-m-cube')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),
            Stat::make('Mutasi Bulan Ini', \App\Models\AssetMutation::whereMonth('mutation_date', now()->month)->count())
                ->description('Pergerakan aset bulan ini')
                ->descriptionIcon('heroicon-m-arrows-right-left')
                ->color('success'),
            Stat::make('Permintaan Stok Pending', \App\Models\StockRequest::where('status', 'pending')->count())
                ->description('Perlu persetujuan segera')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Total Pengguna', \App\Models\User::count())
                ->description('Petugas & Administrator')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}
