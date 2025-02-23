<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OperacaoResource\Pages;
use App\Filament\Resources\OperacaoResource\RelationManagers;
use App\Models\Operacao;
use App\Models\Ativo;
use App\Models\Carteira;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInputmask;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Grid;
use Leandrocfe\FilamentPtbrFormFields\Money;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\Modal;
//use Filament\Support\Enums\MaxWidth;
//use Filament\Forms\Components\Money;

class OperacaoResource extends Resource
{
    protected static ?string $model = Operacao::class;
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-ripple';
    protected static ?string $navigationLabel = 'Operações';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make()

                ->schema([
                    Select::make('id_carteira')
                        ->label('Carteira')
                        ->required()
                        ->searchable()
                        ->options((
                        Carteira::all()->sortBy('Nome')->where('status',1)->pluck('Nome','id')->toArray()
                        )),
                    Forms\Components\Select::make('id_ativo')
                        ->label('Ativo')
                        ->required()
                        ->searchable()
                        ->options((
                        Ativo::all()->sortBy('Ticket')->where('status',1)->pluck('Ticket','id')->toArray()
                        )),
                    Forms\Components\DatePicker::make('data')
                        ->label('Data')
                        ->required(),
                    TextInput::make('qtd')
                        ->label('Quantidade')
                        //->live(debounce: 1)
                        ->numeric(),
                    TextInput::make('valor_unitario')
                        ->label('Valor Unitário')
                        ->live(debounce: 500) // Atualiza automaticamente
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            $qtd = floatval(str_replace(',', '.', $get('qtd') ?? 0)); // Converte para número
                            $valorUnitario = floatval(str_replace(',', '.', $get('valor_unitario') ?? 0));
                            $set('valor_total', $qtd * $valorUnitario);
                        })
                        ->formatStateUsing(function ($state) {
                            // Substitui vírgula por ponto
                            return str_replace(',', '.', $state);
                        })
                        ->prefix('R$'),
                        Forms\Components\TextInput::make('valor_total')
                        ->label('Valor Total')
                        ->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.'))
                        ->prefix('R$')
                        ->numeric()
                        ->disabled(),
                    Forms\Components\Radio::make('tipo')
                        ->inline()
                        ->default('C')
                        ->options([
                            'C' => 'Compra',
                            'V' => 'Venda',
                        ]),

                ])
                ->columns(3),
                Forms\Components\TextInput::make('obs')
                ->label('Observação')
                ->columnSpan(3),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1))
            ->defaultSort('data','desc')
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
            ->columns([
                Tables\Columns\TextColumn::make('data')
                    ->label('Data')
                    ->date($format = 'd/m/y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('carteira.Nome')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ativo.Ticket')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qtd')
                    ->label('Qtd')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('valor_unitario')
                    ->label('V. Unitário')
                    ->money('brl'),
                Tables\Columns\TextColumn::make('valor_total')
                    ->label('V. Total')
                 ->money('BRL'),
                Tables\Columns\TextColumn::make('tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'C' => 'success',
                        'V' => 'danger',
                    }),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
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
            'index' => Pages\ListOperacaos::route('/'),
            'create' => Pages\CreateOperacao::route('/create'),
            'view' => Pages\ViewOperacao::route('/{record}'),
            'edit' => Pages\EditOperacao::route('/{record}/edit'),
        ];
    }
    /*public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }*/
}
