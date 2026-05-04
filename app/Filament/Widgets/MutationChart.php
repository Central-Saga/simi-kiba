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
            ->where('mutation_date', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Mutasi',
                    'data' => $data->pluck('count')->toArray(),
                    'fill' => 'start',
                    'borderColor' => '#10b981',
                    'backgroundColor' => '#10b98133',
                ],
            ],
            'labels' => $data->pluck('month')->map(fn($m) => \Illuminate\Support\Carbon::parse($m)->format('M Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
