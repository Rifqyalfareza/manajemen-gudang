<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Customer;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\Supplier;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $title = 'Statistik';
    protected function getStats(): array
    {
        return [
            Stat::make('Total Produk', Product::where('stock', '>', 0)
                ->count())
                ->description('Jumlah total produk yang tersedia.')
                ->descriptionColor('primary')
                ->color('primary'),
            Stat::make('Total Supplier', Supplier::count())
                ->description('Jumlah total supplier terdaftar.')
                ->descriptionColor('primary')
                ->color('primary'),
            Stat::make('Total Pelanggan', Customer::count())
                ->description('Jumlah total pelanggan terdaftar.')
                ->descriptionColor('primary')
                ->color('primary'),
            Stat::make('Total Stok Masuk', StockIn::sum('quantity'))
                ->description('Jumlah total stok masuk dari semua produk.')
                ->descriptionColor('success')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Stok Keluar', StockOut::sum('quantity'))
                ->description('Jumlah total stok keluar dari semua produk.')
                ->descriptionColor('danger')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Barang Masuk', StockIn::whereDate('date', today())->count())
                ->description('Jumlah barang masuk hari ini.')
                ->descriptionColor('warning')
                ->color('warning'),
        ];
    }
}
