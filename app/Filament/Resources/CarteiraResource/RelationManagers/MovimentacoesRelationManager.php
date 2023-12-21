<?php

namespace App\Filament\Resources\CarteiraResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovimentacoesRelationManager extends RelationManager
{
    protected static string $relationship = 'movimentacoes';
    protected static string $navigationLabel = 'Movimentações';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('data')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('valot_total')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tipo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('obs')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('data')
                ->date($format = 'd/m/y')
                ->sortable(),
                Tables\Columns\TextColumn::make('tipo')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                'A' => 'success',
                'S' => 'danger',}),
                Tables\Columns\TextColumn::make('valor_total')
                ->Label('Valor')
                ->sortable()
                ->money('brl'),
            ])

            ->filters([
                //
            ])
            ->headerActions([
             //   Tables\Actions\CreateAction::make(),
            ])
            ->actions([
               // Tables\Actions\EditAction::make(),
               // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
             //   Tables\Actions\BulkActionGroup::make([
            //        Tables\Actions\DeleteBulkAction::make(),
              //  ]),
            ]);
    }
}
