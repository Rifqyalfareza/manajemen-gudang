<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\StockOut;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestStockOut extends BaseWidget
{
    protected static ?int $sort = 5;
    protected static ?string $title = 'Stok Keluar Terbaru';
    public function table(Table $table): Table
    {

        return $table
            ->query(StockOut::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('no')->rowIndex()->label('#'),
                TextColumn::make('product.code')->label('Kode Product')->searchable(),
                TextColumn::make('product.name')->label('Product')->searchable(),
                TextColumn::make('customer.name')->label('Customer')->searchable(),
                TextColumn::make('quantity')->label('Quantity')->searchable()->badge(),
                TextColumn::make('product.unit.name')->label('Satuan')->searchable()->badge(),
                TextColumn::make('date')->label('Date')->searchable()->date(),
            ]);
    }
}
