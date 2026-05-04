<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class AssetConditionChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    protected ?string $heading = 'Komposisi Kondisi Aset';


    protected function getData(): array
    {
        $data = \App\Models\Asset::query()
            ->select('condition', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->groupBy('condition')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Aset',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => [
                        '#10b981', // emerald
                        '#f59e0b', // amber
                        '#ef4444', // red
                        '#3b82f6', // blue
                        '#8b5cf6', // violet
                    ],
                ],
            ],
            'labels' => $data->pluck('condition')->map(fn($c) => ucfirst($c))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
