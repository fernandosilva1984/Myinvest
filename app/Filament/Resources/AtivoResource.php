<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput;
use App\Filament\Resources\AtivoResource\Pages;
use App\Filament\Resources\AtivoResource\RelationManagers;
use App\Models\Ativo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Grid;

class AtivoResource extends Resource
{
    protected static ?string $model = Ativo::class;
    protected static ?string $navigationGroup = 'Cadastro';
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()

                ->schema([
                Forms\Components\TextInput::make('Ticket')
                   ->required()
                   ->columnSpan(1)
                   ->maxLength(255),
                Forms\Components\TextInput::make('Razao_Social')
                    ->label(label: 'Razão Social')
                    ->columnSpan(3)
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('CNPJ')
                    ->label(label: 'CNPJ')
                    ->mask('99.999.999/9999-99')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('Tipo')
                    ->options([
                        'Ações' => 'Ações',
                        'FII' => 'FII',
                        'Renda Fixa' => 'Renda Fixa',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('Segmento')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('qtd_cotas')
                    ->label(label: 'Quantidade de cotas')
                    ->currencyMask(thousandSeparator: '.')
                    ->required(),
                Forms\Components\TextInput::make('Valor_mercado')
                    ->label(label: 'Valor de mercado')
                    ->prefix('R$')
                    ->currencyMask(thousandSeparator: '.',decimalSeparator: ',', precision: 2)
                    ->required(),
                Forms\Components\TextInput::make('Valor_patrimonio')
                    ->label(label: 'Valor Patrimonial')
                    ->prefix('R$')
                    ->currencyMask(thousandSeparator: '.',decimalSeparator: ',', precision: 2)
                    ->required(),
                Forms\Components\TextInput::make('Valor_PCota')
                    ->label(label: 'Valor por unid')
                    ->prefix('R$')
                    ->currencyMask(thousandSeparator: '.',decimalSeparator: ',', precision: 2)
                    ->required(),
                Forms\Components\Toggle::make('status')
                    ->required(),
                ])
                ->columns(4)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Ticket')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Razao_Social')
                    ->searchable()
                    ->label(label:'Razão Social'),
                Tables\Columns\TextColumn::make('Valor_mercado')
                    ->label(label: 'Valor de mercado')
                    ->money('brl'),
                Tables\Columns\TextColumn::make('Valor_patrimonio')
                    ->label(label: 'Valor patrimonial')
                    ->money('brl'),
               /* Tables\Columns\TextColumn::make('qtd_cotas')
                    ->label(label: 'Quant de cotas'),*/
                Tables\Columns\TextColumn::make('Valor_PCota')
                    ->label(label: 'Valor Unit')
                    ->money('brl'),
                Tables\Columns\TextColumn::make('Tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Segmento')
                    ->searchable(),

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
            'index' => Pages\ListAtivos::route('/'),
            'create' => Pages\CreateAtivo::route('/create'),
            'edit' => Pages\EditAtivo::route('/{record}/edit'),
        ];
    }
}
