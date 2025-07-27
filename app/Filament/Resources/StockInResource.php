<?php

namespace App\Filament\Resources;

use Dom\Text;
use Filament\Forms;
use Filament\Tables;
use App\Models\StockIn;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StockInResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StockInResource\RelationManagers;
use Filament\Forms\Components\DatePicker;

class StockInResource extends Resource
{
    protected static ?string $model = StockIn::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';
    protected static ?string $navigationLabel = 'Stok Masuk';
    protected static ?string $pluralLabel = 'Daftar Stok Masuk';
    protected static ?string $navigationGroup = 'Inventory Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                    ->relationship('product', 'Name')
                    ->required()
                    ->label('Product')
                    ->searchable()
                    ->preload(),
                Select::make('supplier_id')
                    ->relationship('supplier', 'Name')
                    ->required()
                    ->label('Supplier')
                    ->searchable()
                    ->preload(),
                TextInput::make('quantity')->required()->numeric(),
                DatePicker::make('date')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')->rowIndex()->label('#')->searchable(),
                TextColumn::make('product.name')->label('Product')->searchable(),
                TextColumn::make('supplier.name')->label('Supllier')->searchable(),
                TextColumn::make('quantity')->label('Quantity')->searchable()->badge(),
                TextColumn::make('date')->label('Date')->searchable()->date(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListStockIns::route('/'),
            // 'create' => Pages\CreateStockIn::route('/create'),
            // 'edit' => Pages\EditStockIn::route('/{record}/edit'),
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
