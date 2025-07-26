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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                    ->relationship('product', 'Name')
                    ->required()
                    ->label('Product'),
                Select::make('supplier_id')
                    ->relationship('supplier', 'Name')
                    ->required()
                    ->label('Supplier'),
                TextInput::make('quantity')->required()->numeric(),
                DatePicker::make('date')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')->rowIndex()->label('#'),
                TextColumn::make('product.name')->label('Product'),
                TextColumn::make('supplier.name')->label('Supllier'),
                TextColumn::make('quantity')->label('Quantity'),
                TextColumn::make('date')->label('Date'),
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
            'create' => Pages\CreateStockIn::route('/create'),
            'edit' => Pages\EditStockIn::route('/{record}/edit'),
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
