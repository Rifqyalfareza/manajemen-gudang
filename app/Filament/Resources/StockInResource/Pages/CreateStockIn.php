<?php

namespace App\Filament\Resources\StockInResource\Pages;

use App\Filament\Resources\StockInResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Product;

class CreateStockIn extends CreateRecord
{
    protected static string $resource = StockInResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        $product = $this->record->product;
        $product->increment('stock', $this->record->quantity);
    }
}
