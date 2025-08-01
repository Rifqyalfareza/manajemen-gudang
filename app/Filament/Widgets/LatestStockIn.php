<?php

namespace App\Filament\Widgets;

use App\Models\StockIn;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestStockIn extends BaseWidget
{
    protected static ?int $sort = 4;
    protected static ?string $title = 'Stok Masuk Terbaru';
    public function table(Table $table): Table
    {
        return $table
            ->query(StockIn::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('no')->rowIndex()->label('#'),
                TextColumn::make('product.name')->label('Product')->searchable(),
                TextColumn::make('supplier.name')->label('Supplier')->searchable(),
                TextColumn::make('quantity')->label('Quantity')->searchable()->badge(),
                TextColumn::make('date')->label('Date')->searchable()->date(),
            ]);
    }
}
