<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput;
use App\Filament\Resources\AtivoResource\Pages;
use App\Filament\Resources\AtivoResource\RelationManagers;
use App\Models\Ativo;
use App\Models\tipoAtivo;
use App\Models\segmentoAtivo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Grid;

class AtivoResource extends Resource
{
    protected static ?string $model = Ativo::class;
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 1;

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
                    Forms\Components\Select::make('id_tipoAtivo')
                    ->label('Tipo')
                    ->required()
                    ->searchable()
                    ->options((
                    tipoAtivo::all()->sortBy('tipoAtivo')->pluck('tipoAtivo','id')->toArray()
                    ))
                    ->required(),
                    Forms\Components\Select::make('id_segmentoAtivo')
                    ->label('Segmento')
                    ->required()
                    ->searchable()
                    ->options((
                    segmentoAtivo::all()->sortBy('segmentoAtivo')->pluck('segmentoAtivo','id')->toArray()
                    ))
                    ->required(),
                Forms\Components\TextInput::make('qtd_cotas')
                    ->numeric()
                    ->maxLength(255)
                    ->label(label: 'Quantidade de cotas')
                   // ->currencyMask(thousandSeparator: '.')
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
        ->groups([
            Group::make('tipoAtivo.tipoAtivo')
            ->label('Tipo')
            ->collapsible()
            ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('tipoAtivo', $direction)),
        ])
        ->groups([
            Group::make('segmentoAtivo.segmentoAtivo')
            ->label('Segmento')
            ->collapsible()
            ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('segmentoAtivo', $direction)),
          ])
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
                Tables\Columns\TextColumn::make('tipoAtivo.tipoAtivo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('segmentoAtivo.segmentoAtivo')
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
