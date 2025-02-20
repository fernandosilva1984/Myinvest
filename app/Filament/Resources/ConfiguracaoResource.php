<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConfiguracaoResource\Pages;
use App\Filament\Resources\ConfiguracaoResource\RelationManagers;
use App\Models\Configuracao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConfiguracaoResource extends Resource
{
    protected static ?string $model = Configuracao::class;

    protected static ?string $navigationGroup = 'Configurações';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationLabel = 'Parametros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('CDI_atual')
                    ->label('CDI Atual %')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('Corretagem_acoes')
                    ->label('Corretagem Ações %')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('Corretagem_fii')
                    ->label('Corretagem FIIs %')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('Corretagem_criptos')
                    ->label('Corretagem Criptos %')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('CDI_atual')
                    ->label('CDI Atual %')
                    ->suffix('%')
                    ->numeric(),
                Tables\Columns\TextColumn::make('Corretagem_acoes')
                    ->label('Corretagem Ações %')
                    ->suffix('%')
                    ->numeric(),
                Tables\Columns\TextColumn::make('Corretagem_fii')
                    ->label('Corretagem FIIs %')
                    ->suffix('%')
                    ->numeric(),
                Tables\Columns\TextColumn::make('Corretagem_criptos')
                    ->label('Corretagem Criptos %')
                    ->suffix('%')
                    ->numeric(),

            ])
            ->filters([
                //
            ])
            ->actions([

                Tables\Actions\EditAction::make()
                ->label('')
                ->tooltip('Editar'),
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
            'index' => Pages\ListConfiguracaos::route('/'),

            'view' => Pages\ViewConfiguracao::route('/{record}'),
            'edit' => Pages\EditConfiguracao::route('/{record}/edit'),
        ];
    }
}
