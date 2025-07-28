<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use Filament\Tables\Columns\TextColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Inventory Management';
    protected static ?string $navigationLabel = 'Produk';
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Code Product')
                    ->default(function () { 
                        return 'PRD-' . mt_rand(1000, 9999); 
                    })
                    ->required()
                    ->unique()
                    ->disabled()
                    ->dehydrated(),
                TextInput::make('name')->required(),
                Select::make('categories_id')
                    ->relationship('category', 'Name')
                    ->required()
                    ->createOptionForm([
                        TextInput::make('name')->required(),
                    ]),
                TextInput::make('stock')->required()->numeric(),
                Select::make('unit_id')
                    ->relationship('unit', 'Name')
                    ->required()
                    ->createOptionForm([
                        TextInput::make('name')->required(),
                    ]),
                TextInput::make('min_stock')->required()->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')->rowIndex()->label('#'),
                TextColumn::make('code')->searchable()->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('category.name')->searchable()->sortable(),
                TextColumn::make('unit.name')->searchable()->sortable(),
                TextColumn::make('stock')->searchable()->sortable(),
                TextColumn::make('min_stock')->searchable()->sortable(),

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
            'index' => Pages\ListProducts::route('/'),
            // 'create' => Pages\CreateProduct::route('/create'),
            // 'edit' => Pages\EditProduct::route('/{record}/edit'),
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
