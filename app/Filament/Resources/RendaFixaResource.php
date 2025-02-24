<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RendaFixaResource\Pages;
use App\Filament\Resources\RendaFixaResource\RelationManagers;
use App\Models\RendaFixa;
use App\Models\Ativo;
use App\Models\Banco;
use App\Models\Carteira;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Leandrocfe\FilamentPtbrFormFields\Money;
use Filament\Forms\Components\Grid;
use Filament\Forms\Get;
use Filament\Forms\Set;

class RendaFixaResource extends Resource
{
    protected static ?string $model = RendaFixa::class;
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 11;
    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';
    protected static ?string $navigationLabel = 'Renda Fixa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                ->schema([
                Select::make('id_carteira')
                    ->columnSpan(2)
                    ->label('Carteira')
                    ->required()
                    ->searchable()
                    ->options((
                Carteira::all()->sortBy('Nome')->where('status',1)->pluck('Nome','id')->toArray() ))
                    ->required(),
                Select::make('id_ativo')
                    ->columnSpan(2)
                    ->label('Tipo')
                    ->required()
                    ->searchable()
                    ->options((
                Ativo::all()->sortBy('Ticket')->where('status',1)->where('id_tipo',3)->pluck('Ticket','id')->toArray() ))
                    ->required(),
                TextInput::make('descrição')
                    ->columnSpan(6)
                    ->label('Descrição')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('data_aplicacao')
                    ->columnSpan(2)
                    ->label('Data da Aplicação')
                    ->required(),
                TextInput::make('prazo')
                    ->columnSpan(2)
                    ->label( 'Prazo da Aplicação')
                    ->required()
                    ->suffix('Dias')
                    ->numeric()
                    ->live(debounce: 1000) // Torna o campo reativo para escutar mudanças
                    ->afterStateUpdated(function ($state, $set) {
                        // Quando o prazo é alterado, recalcula a data de vencimento
                        $dataAplicacao = request('data_aplicacao');
                            $dataVenc = Carbon::parse($dataAplicacao)->addDays($state);
                            $set('data_venc', $dataVenc->format('Y-m-d'));
                    }),
                DatePicker::make('data_venc')
                    ->columnSpan(2)
                    ->label( 'Vencimento')
                    ->required(),
                TextInput::make('valor_aplic')
                    ->columnSpan(2)
                    ->label( 'Valor da Aplicação')
                    ->prefix('R$')
                    ->live(debounce: 1500) // Torna o campo reativo para escutar mudanças
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        // Quando o prazo é alterado, recalcula a data de vencimento
                        //$valor_Aplicacao = floatval(str_replace(',', '.', $get('valor_aplic') ?? 0));
                     //   $valorUnitario = floatval(str_replace(',', '.', $get('valor_unitario') ?? 0));
                            $set('valor_atual', $get('valor_aplic'));
                            })
                    ->required(),
                TextInput::make('valor_atual')
                   ->columnSpan(2)
                   ->readonly(),
                    //->hidden(),
                    TextInput::make('taxa')
                    ->columnSpan(2)
                    ->label( 'Taxa de ref.')
                    ->required()
                    ->suffix('%')
                    ->numeric(),
                TextInput::make('taxa_rent')
                    ->columnSpan(2)
                    ->label( 'Rentabilidade')
                    ->required()
                    ->suffix('%')
                    ->numeric(),
                Select::make('id_banco_emissor')
                    ->columnSpan(2)
                    ->label('Banco Emissor')
                    ->required()
                    ->searchable()
                    ->options((
                        Banco::all()->sortBy('nome')->where('status',1)->pluck('nome','id')->toArray() ))
                    ->required(),
                Select::make('id_banco_gestor')
                    ->columnSpan(2)
                    ->label('Banco Gestor')
                    ->required()
                    ->searchable()
                    ->options((
                        Banco::all()->sortBy('nome')->where('status',1)->pluck('nome','id')->toArray() ))
                    ->required(),
                TextInput::make('conta')
                    ->columnSpan(2)
                    ->required()
                    ->maxLength(255),
                Toggle::make('status')
                    ->default(true)
                    ->required(),
            ])
            ->columns(10)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->striped()
        ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1))
        ->defaultSort('data_aplicacao','desc')
        ->groups([
            Group::make('carteira.Nome')
            ->label('Carteira')
            ->collapsible()
            ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('Nome', $direction)),
        ])
        ->groups([
            Group::make('ativo.Ticket')
            ->label('Ativo')
            ->collapsible()
            ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('Ticket', $direction)),
        ])
        ->groups([
            Group::make('banco_Emissor.nome')
            ->label('Banco')
            ->collapsible()
            ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('Nome', $direction)),
        ])
            ->columns([
                Tables\Columns\TextColumn::make('carteira.Nome')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_aplicacao')
                    ->label('Data Aplic.')
                    ->date($format = 'd/m/y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ativo.Ticket')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                /*Tables\Columns\TextColumn::make('descrição')
                    ->searchable(),*/
                Tables\Columns\TextColumn::make('valor_aplic')
                    ->label('Valor Aplic.')
                    ->numeric()
                    ->sortable()
                    ->money('brl'),
                Tables\Columns\TextColumn::make('iof')
                    ->label('IOF')
                    ->numeric()
                    ->money('brl')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ir')
                    ->label('IR')
                    ->numeric()
                    ->money('brl')
                    ->sortable(),
                Tables\Columns\TextColumn::make('valor_atual')
                    ->label('Valor Bruto')
                    ->numeric()
                    ->sortable()
                    ->money('brl'),
                    Tables\Columns\TextColumn::make('valor_aliquido')
                    ->label('Valor líquido')
                    ->numeric()
                    ->sortable()
                    ->money('brl')
                    ->getStateUsing(function ($record) {
                        return $record->valor_atual - ($record->iof + $record->ir);
                      }),
                /*Tables\Columns\TextColumn::make('banco_Emissor.nome')
                    ->label('Emissor')
                    ->numeric()
                    ->searchable()
                    ->sortable(),*/
                Tables\Columns\TextColumn::make('conta')
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
            'index' => Pages\ListRendaFixas::route('/'),
            'create' => Pages\CreateRendaFixa::route('/create'),
            'view' => Pages\ViewRendaFixa::route('/{record}'),
            'edit' => Pages\EditRendaFixa::route('/{record}/edit'),
        ];
    }
}
