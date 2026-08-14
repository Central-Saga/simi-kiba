<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class MutationChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 1;

    protected ?string $heading = 'Tren Mutasi Aset (6 Bulan Terakhir)';


    protected function getData(): array
    {
        $data = \App\Models\AssetMutation::query()
            ->select(\Illuminate\Support\Facades\DB::raw('DATE_FORMAT(mutation_date, "%Y-%m") as month'), \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->where('mutation_date', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $labels = [];
        $counts = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthString = now()->subMonths($i)->format('Y-m');
            $labels[] = now()->subMonths($i)->format('M Y');
            $counts[] = $data[$monthString] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Mutasi',
                    'data' => $counts,
                    'fill' => 'start',
                    'borderColor' => '#10b981',
                    'backgroundColor' => '#10b98133',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
