<?php

namespace App\Filament\Widgets;

use App\Models\StockIn;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class StockInChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Stok Masuk Per Bulan';

    protected function getData(): array
    {
        $data = Trend::model(StockIn::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->dateColumn('date')
            ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Stok Masuk',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgba(5, 150, 105, 1)',
                    'backgroundColor' => 'rgba(5, 150, 105, 0.2)',
                    'fill' => true,
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
