<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarteiraResource\Pages;
use App\Filament\Resources\CarteiraResource\RelationManagers;
use App\Models\Carteira;
use App\Models\Movimentacao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Grid;

class CarteiraResource extends Resource
{
    protected static ?string $model = Carteira::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                
                ->schema([
                Forms\Components\TextInput::make('Nome')
                ->label(label: 'Carteira')
                ->required()
                ->columnSpan(1)
                ->maxLength(255),
                Forms\Components\TextInput::make('Proprietario')
                ->label(label: 'Proprietário')
                ->required()
                ->columnSpan(2)
                
                ->maxLength(255),
                Forms\Components\TextInput::make('Valor_Investido')
                ->label(label: 'Valor investido')
                ->prefix('R$')
                    ->required()
                    ->currencyMask(thousandSeparator: '.',decimalSeparator: ',', precision: 2),
                Forms\Components\TextInput::make('Valor_Mercado')
                ->label(label: 'Valor de mercado')
                    ->prefix('R$')
                    ->required()
                    ->currencyMask(thousandSeparator: '.',decimalSeparator: ',', precision: 2),
                Forms\Components\TextInput::make('Resultado')
                ->suffix('%')
                    ->required()
                    ->currencyMask(thousandSeparator: '.',decimalSeparator: ',', precision: 2),
               
                ])
                ->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                Tables\Columns\TextColumn::make('Nome')
                    ->searchable()
                ->label(label: 'Carteira'),
                Tables\Columns\TextColumn::make('Proprietario')
                ->searchable()
                ->label(label: 'Proprietário'),
                Tables\Columns\TextColumn::make('Valor_Investido')
                ->money('brl')
                ->label(label: 'Valor investido'),
                Tables\Columns\TextColumn::make('Valor_Mercado')
                ->money('brl')
                ->label(label: 'Valor de mercado'),
                Tables\Columns\TextColumn::make('Resultado')
                ->numeric(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->label('')
                ->tooltip('Visualizar'),
                Tables\Actions\EditAction::make()
                ->label('')
                ->tooltip('Editar'),
                Tables\Actions\DeleteAction::make()
                ->label('')
                ->tooltip('Excluir'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCarteiras::route('/'),
            'create' => Pages\CreateCarteira::route('/create'),
            'edit' => Pages\EditCarteira::route('/{record}/edit'),
        ];
    }
}
