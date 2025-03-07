<?php

namespace App\Filament\Resources;


use Filament\Tables\Columns\Layout\Grid;
use App\Filament\Resources\PosicaoResource\Pages;
use App\Filament\Resources\PosicaoResource\RelationManagers;
use App\Models\Posicao;
use App\Models\Carteira;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PosicaoResource extends Resource
{
    protected static ?string $model = Carteira::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';
    protected static ?string $navigationLabel = 'Resumo de Invest.';

    
    public static function table(Table $table): Table
    {
        return $table
        //->modifyQueryUsing(fn (Builder $query) => $query->groupby('id_carteira'))
            ->columns([
                TextColumn::make('Nome')
                    ->searchable()
                    ->label(label: 'Carteira'),
                TextColumn::make('RFAtual')
                    ->money('brl')
                    ->label('Renda Fixa')
                    ->getStateUsing(fn ($record) => $record->getRendaFixa()),
                TextColumn::make('fiis')
                    ->money('brl')
                    ->label('FIIs')
                    ->getStateUsing(fn ($record) => $record->getSaldoFII()),
                TextColumn::make('acoes')
                    ->money('brl')
                    ->label('Ações')
                    ->getStateUsing(fn ($record) => $record->getSaldoACOES()),
                TextColumn::make('cripto')
                    ->money('brl')
                    ->label('Criptos')
                    ->getStateUsing(fn ($record) => $record->getSaldoCripto()),
                Tables\Columns\TextColumn::make('totalinvest')
                    ->money('brl')
                    ->label(label: 'Total Investido')
                    ->getStateUsing(function ($record) {
                        return $record->getAplicado();}),
                
                Tables\Columns\TextColumn::make('saldo')
                    ->money('brl')
                    ->label(label: 'Total Aportes')
                    ->getStateUsing(function ($record) {
                        return $record->saldo();}),

                Tables\Columns\TextColumn::make('resultado')
                    ->money('brl')
                    ->label(label: 'Resultado')
                    ->getStateUsing(function ($record) {
                        return $record->getResultado();}),
                ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosicaos::route('/'),
            
        ];
    }    
}
