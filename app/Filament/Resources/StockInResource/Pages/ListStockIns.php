<?php

namespace App\Filament\Resources\StockInResource\Pages;

use App\Filament\Resources\StockInResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Product;


class ListStockIns extends ListRecords
{
    protected static string $resource = StockInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    // protected function afterCreate(): void
    // {
    //     $product = $this->record->product;
    //     $product->increment('stock', $this->record->quantity);
    // }
}
