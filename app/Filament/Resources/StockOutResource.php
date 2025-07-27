<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockOutResource\Pages;
use App\Filament\Resources\StockOutResource\RelationManagers;
use App\Models\StockOut;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Date;

class StockOutResource extends Resource
{
    protected static ?string $model = StockOut::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';
    protected static ?string $navigationLabel = 'Stok Keluar';
    protected static ?string $pluralLabel = 'Daftar Stok Keluar';
    protected static ?string $navigationGroup = 'Inventory Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                    ->label('Product')
                    ->required()
                    ->relationship('product', 'name'),
                Select::make('customer_id')
                    ->label('Customer')
                    ->required()
                    ->relationship('customer', 'name'),
                TextInput::make('quantity')
                    ->label('Quantity')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->rules([
                        function (\Filament\Forms\Get $get) {
                        return function (string $attribute, $value, \Closure $fail) use ($get) {
                            $productId = $get('product_id');
                            $product = \App\Models\Product::find($productId);

                            if ($product && $value > $product->stock) {
                                $fail("Jumlah keluar melebihi stok saat ini ({$product->stock}).");
                            }
                        };
                    }
                    ]),
                    DatePicker::make('date')
                    ->label('Date')
                    ->default(Date::now())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->rowIndex()
                    ->label('#')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('product.name')
                    ->label('Produk')
                    ->searchable(),
                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable()
                    ->searchable()
                    ->badge(),
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockOuts::route('/'),
            'create' => Pages\CreateStockOut::route('/create'),
            'edit' => Pages\EditStockOut::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
