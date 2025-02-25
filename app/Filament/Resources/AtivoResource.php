<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
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
use Leandrocfe\FilamentPtbrFormFields\Money;

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
                TextInput::make('Ticket')
                   ->required()
                   ->columnSpan(1)
                   ->maxLength(255),
                TextInput::make('Razao_Social')
                    ->label(label: 'Razão Social')
                    ->columnSpan(3)
                    ->required()
                    ->maxLength(255),
                TextInput::make('CNPJ')
                    ->label(label: 'CNPJ')
                    ->mask('99.999.999/9999-99')
                    ->required()
                    ->maxLength(255),
                Select::make('id_tipo')
                    ->label('Tipo')
                    ->required()
                    ->searchable()
                    ->options((
                    tipoAtivo::all()->sortBy('tipoAtivo')->pluck('tipoAtivo','id')->toArray()
                    ))
                    ->required(),
                Select::make('id_segmento')
                    ->label('Segmento')
                    ->required()
                    ->searchable()
                    ->options((
                    segmentoAtivo::all()->sortBy('segmentoAtivo')->pluck('segmentoAtivo','id')->toArray()
                    ))
                    ->required(),
                TextInput::make('qtd_cotas')
                    ->numeric()
                    ->maxLength(255)
                    ->label(label: 'Quantidade de cotas')
                    ->required(),
                TextInput::make('qtd_meta')
                    ->numeric()
                    ->maxLength(255)
                    ->label(label: 'Meta de cotas')
                    ->required(),

                 Money::make('Valor_patrimonio')
                    ->label(label: 'Valor Patrimonial')
                    ->prefix('R$')
                    ->required(),
                   /* Money::make('Valor_PCota')
                    ->label(label: 'Cotação Atual')
                    ->prefix('R$')
                    ->required(),*/
                Toggle::make('status')
                    ->required(),
                ])
                ->columns(4)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        //->defaultPaginationPageOption(25)
        ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1))
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
                    ->limit(35)
                    ->label(label:'Razão Social'),
                Tables\Columns\TextColumn::make('Valor_mercado')
                    ->label(label: 'Valor de mercado')
                    ->money('brl')
                    ->getStateUsing(function ($record) {
                        // Verifica se qtd_cotas ou cotacaoAtual.valor são zero ou nulos
                        if (empty($record->qtd_cotas) || empty($record->cotacaoAtual->valor)) {
                            return 0; // Retorna 0 se algum dos valores for inválido
                        }
                        // Calcula o valor de mercado multiplicando qtd_cotas por cotacaoAtual.valor
                        return $record->qtd_cotas * $record->cotacaoAtual->valor;
                      }),
                Tables\Columns\TextColumn::make('Valor_patrimonio')
                    ->label(label: 'Valor patrimonial')
                    ->money('brl'),
                    Tables\Columns\TextColumn::make('saldo_operacoes')
                    ->label('Qtd. Cotas')
                    ->getStateUsing(function ($record) {
                        // Chama a função saldoOperacoes do model Ativo
                        return $record->saldoOperacoes();
                    })
                    ->numeric() // Formata como número
                    ->sortable(), // Permite ordenação
                Tables\Columns\TextColumn::make('cotacaoAtual.valor')
                    ->label(label: 'Cotação')
                    ->money('brl'),
                Tables\Columns\TextColumn::make('tipoAtivo.tipoAtivo')
                    ->label('Tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('segmentoAtivo.segmentoAtivo')
                    ->label('Segmento')
                    ->limit(13)
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
                ->modalHeading('Tem certeza?')
                ->modalDescription('Essa ação não pode ser desfeita.')
                ->modalButton('Excluir')
                ->modalWidth('md') // ✅ Correção: Usando o enum corretamente
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
