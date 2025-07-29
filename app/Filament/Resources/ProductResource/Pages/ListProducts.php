<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use App\Models\Product;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProductResource;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function hasMounted():void
    {
        parent::mount();
        $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')->get();

        if ($lowStockProducts->count() > 0) {
            $productNames = $lowStockProducts->pluck('name')->implode(', ');

            Notification::make()
                ->title('Peringatan Stok Menipis')
                ->body("Produk berikut mendekati atau melewati batas minimum: {$productNames}")
                ->danger()
                ->persistent() // tidak hilang otomatis
                ->send();
        }
    }
}
