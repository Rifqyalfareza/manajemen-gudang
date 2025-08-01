<?php

namespace App\Filament\Widgets;

use App\Models\StockOut;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class StockOutChart extends ChartWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = 'Stok Keluar Per Bulan';

    protected function getData(): array
    {
        $data = Trend::model(StockOut::class)
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
                    'label' => 'Stok keluar',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgba(255, 0, 0, 1)',
                    'backgroundColor' => 'rgba(255, 0, 0, 0.2)',
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
