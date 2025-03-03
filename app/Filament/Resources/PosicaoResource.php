<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PosicaoResource\Pages;
use App\Filament\Resources\PosicaoResource\RelationManagers;
use App\Models\Posicao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PosicaoResource extends Resource
{
    protected static ?string $model = Posicao::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('carteira.Nome')
                    ->searchable()
                    ->label(label: 'Carteira'),
                Tables\Columns\TextColumn::make('RFAtual')
                    ->money('brl')
                    ->label(label: 'Renda Fixa')
                    ->getStateUsing(function ($record) {
                        return $record->getRendaFixa();}),  
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListPosicaos::route('/'),
            'create' => Pages\CreatePosicao::route('/create'),
            'edit' => Pages\EditPosicao::route('/{record}/edit'),
        ];
    }    
}
