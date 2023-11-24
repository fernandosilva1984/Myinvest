<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarteiraResource\Pages;
use App\Filament\Resources\CarteiraResource\RelationManagers;
use App\Models\Carteira;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarteiraResource extends Resource
{
    protected static ?string $model = Carteira::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Nome')
                ->label(label: 'Carteira')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('Proprietario')
                ->label(label: 'Proprietário')
                ->required()
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
                Forms\Components\Toggle::make('status')
                    ->required(),
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
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
